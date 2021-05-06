{{--@extends('welcome')--}}
{{--@section('content')--}}
<button class="btn btn-primary btn-sm" id="add">Add</button>
|
<button class="btn btn-secondary btn-sm" id="edit">Edit</button>
|
<button class="btn btn-danger btn-sm" id="delete">Delete</button>
</button>
<table id="example" class="table table-striped table-bordered customerList" width="100%">
    <thead>
    <tr>
        <th></th>
        @foreach($cols as $k=>$v)
            <th>{{$v}}</th>
        @endforeach
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th></th>
        @foreach($cols as $k=>$v)
            <th>{{$v}}</th>
        @endforeach
    </tr>
    </tfoot>
</table>
<div class="modal fade" id="createCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <input type="hidden" class="modal-data-id" value="0"/>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form class="form" id="customer_form">
                    @csrf
                    <div class="form-body">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="company">Company</label>
                                <input type="text" id="company" class="form-control" placeholder="Company"
                                       name="company"
                                       required>
                            </div>
                            <div class="form-group col">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" class="form-control" placeholder="First Name"
                                       name="first_name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" class="form-control" placeholder="Last Name"
                                       name="last_name" required>
                            </div>
                            <div class="form-group col">
                                <label for="email_address">Email Address</label>
                                <input type="text" id="email_address" class="form-control" placeholder="Email Address"
                                       name="email_address">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="job_title">Job Title</label>
                                <input type="text" id="job_title" class="form-control" placeholder="Job Title"
                                       name="job_title">
                            </div>
                            <div class="form-group col">
                                <label for="business_phone">Business Phone</label>
                                <input type="text" id="business_phone" class="form-control" placeholder="Business Phone"
                                       name="business_phone">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="address">Address</label>
                                <input type="text" id="address" class="form-control" placeholder="Address"
                                       name="address">
                            </div>
                            <div class="form-group col">
                                <label for="city">City</label>
                                <input type="text" id="city" class="form-control" placeholder="City" name="city">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="form-group col">
                                <label for="zip_postal_code">Zip Postal Code</label>
                                <input type="text" id="zip_postal_code" class="form-control"
                                       placeholder="Zip Postal Code"
                                       name="zip_postal_code">
                            </div>
                            <div class="form-group col">
                                <label for="country_region">Country Region</label>
                                <input type="text" id="country_region" class="form-control" placeholder="Country Region"
                                       name="country_region">
                            </div>
                        </div>

                    </div>
                    <div class="form-actions d-flex justify-content-end">
                        <button type="button" id="reset"
                                class="btn btn-warning mr-1" data-dismiss="modal">
                            <i class="ft-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary saveCustomer">
                            <i class="fa fa-check-square-o"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{--@endsection--}}
