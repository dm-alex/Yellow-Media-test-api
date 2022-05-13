<?php

namespace App\Http\Controllers\Api;

use App\DTO\CompanyDto;
use App\Models\Company;
use App\Services\Contracts\CompanyServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpFoundation\Response;

class CompaniesController extends Controller
{
    /**
     * @var CompanyServiceInterface
     */
    private CompanyServiceInterface $companyService;

    /**
     * CompaniesController constructor.
     * @param CompanyServiceInterface $companyService
     */
    public function __construct(CompanyServiceInterface $companyService)
    {
        parent::__construct();

        $this->middleware('auth');

        $this->companyService = $companyService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $companies = $request->user()->companies;

        if($companies->isEmpty()){
            return $this->success([], Response::HTTP_NO_CONTENT);
        }

        try{
            $companies->transform(fn ($item) => new CompanyDto($item->toArray()));
        }catch (\Throwable $exception){
            return $this->failure([$exception->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return $this->success($companies->all(), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $this->failure($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            if (!$this->companyService->create($request->user(), $validator->validated())) {
                return $this->failure(['Can`t create company with given data'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Throwable $exception) {
            return $this->failure(['Can`t create company with given data'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->success(['Company successfully created.'], Response::HTTP_OK);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'title'       => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:3', 'max:5000'],
            'phone'       => ['required',
                              'phone:UA',
                              'max:20',
                              function ($attribute, $value, $fail) {
                                  if (Company::where('phone', (string)PhoneNumber::make($value))->exists()) {
                                      $fail('Company with this ' . $attribute . ' already  exists.');
                                  }
                              }],
        ]);
    }
}
