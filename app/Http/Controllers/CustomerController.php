<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;

class CustomerController extends Controller
{
    public function all()
    {
      $customers = Customers::all();
      return response()->json([
        "customers" => $customers
      ], 200);
    }
    public function get($id)
    {
      $customer = Customers::whereId($id)->first();
      return response()->json([
        "customer" => $customer
      ], 200);
    }
    public function new(Request $request)
    {
      $customer = Customers::create($request->only(["name", "email", "no_phone", "website"]));
      return response()->json([
        "customer" => $customer
      ], 200);
    }
}
