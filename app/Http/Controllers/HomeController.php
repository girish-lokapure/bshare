<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var string[]
     */
    protected $colOrder = ['id', 'company', 'first_name', 'last_name', 'email_address', 'job_title', 'business_phone', 'address', 'city', 'zip_postal_code', 'country_region'];

    /**
     * @return Application|Factory|View
     */
    function index()
    {
        $data['cols'] = [
            'company' => 'Company',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email_address' => 'Email Address',
            'job_title' => 'Job Title',
            'business_phone' => 'Business Phone',
            'address' => 'Address',
            'city' => 'City',
            'zip_postal_code' => 'Zip Postal Code',
            'country_region' => 'Country Region',
            'orders_count' => 'Orders Total',
            'total_value' => 'Orders Total Value',
//            'id' => 'Action'
        ];

        return view('welcome', $data);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteCustomer($id)
    {

        $Customer = Customer::find($id);
        $deleted = $Customer->delete();
        if ($deleted) {
            return true;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function editCustomer($id, Request $request)
    {
        $validatedData = $request->validate(
            [
                'company' => 'required|max:50',
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:50',
                'email_address' => 'sometimes|nullable|email:rfc|max:50',
                'job_title' => 'sometimes|nullable|string|max:50',
                'business_phone' => 'sometimes|nullable|string|max:25',
                'address' => 'sometimes|nullable|string',
                'city' => 'sometimes|nullable|string|max:50',
                'zip_postal_code' => 'sometimes|nullable|string|max:15',
                'country_region' => 'required|nullable|string|max:50',
            ]
        );

        $customer = Customer::find($id);

        try {
            $customer->fill($validatedData);
            $customer->save();
            $error = false;
            $message = 'Updated customer details.';

        } catch (Exception $e) {
            $error = true;
            $message = 'Error while Updating customer details.';
        }

        return response()->json([
            'error' => $error,
            'message' => $message,
        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addCustomer(Request $request)
    {

        $validatedData = $request->validate(
            [
                'company' => 'required|max:50',
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:50',
                'email_address' => 'sometimes|nullable|email:rfc|max:50',
                'job_title' => 'sometimes|nullable|string|max:50',
                'business_phone' => 'sometimes|nullable|string|max:25',
                'address' => 'sometimes|nullable|string',
                'city' => 'sometimes|nullable|string|max:50',
                'zip_postal_code' => 'sometimes|nullable|string|max:15',
                'country_region' => 'required|nullable|string|max:50',
            ]
        );

        $customer = Customer::create($validatedData);

        $customer->save();

        return response()->json([
            'error' => false,
            'message' => 'Customer is created.',
        ]);
    }

    /**
     * @return JsonResponse
     */
    protected function getCustomers()
    {
        extract(request()->all());

        $query = Customer::with('orders')
            ->orderBy($this->colOrder[$order[0]['column']], $order[0]['dir']);

        if (!empty($search['value'])) {
            $searchCols = ['first_name', 'last_name', 'company', 'address', 'city', 'country_region'];
            foreach ($searchCols as $searchCol) {
                $query->orWhere($searchCol, 'LIKE', '%' . $search['value'] . '%');
            }

        }

        $count = $query->count();

        $customers = $query->skip($start)->take($length)
            ->select(['id', 'company', 'first_name', 'last_name', 'email_address', 'job_title', 'business_phone', 'address', 'city', 'zip_postal_code', 'country_region'])
            ->get();

        $customerArr = [];
        foreach ($customers as $customer) {
            $customer->orders_count_new = count($customer['orders']);
            $customer->total_value = $this->getTotalPrice($customer);
            unset($customer['orders']);
            $customerArr[] = array_values($customer->toArray());
        }

        $data = [
            'draw' => (isset($draw)) ? $draw : 0,
            'recordsTotal' => Customer::count(),
            'recordsFiltered' => $count,
            'data' => $customerArr
        ];
        return response()->json($data);
    }

    /**
     * @param $customer
     * @return float|int
     */
    private function getTotalPrice($customer)
    {
        $orderIds = $customer->orders()->pluck('id')->toArray();
        $result = OrderDetail::whereIn('order_id', $orderIds)
            ->selectRaw('SUM(quantity * unit_price) as sum')
            ->first();

        return $result ? (float)$result->sum : 0;
    }

}
