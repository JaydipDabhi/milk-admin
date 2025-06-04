@extends('layouts.index')
@section('title', 'Add Milk Collection')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Milk Collection</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add New Milk Collection</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add New Milk Collection</h3>
                            </div>
                            <form method="POST" action="">
                                {{-- @csrf --}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customerName">Customer Name</label>
                                        <select class="form-control select2" style="width: 100%;">
                                            <option selected="selected">Alabama</option>
                                            <option>Alaska</option>
                                            <option>California</option>
                                            <option>Delaware</option>
                                            <option>Tennessee</option>
                                            <option>Texas</option>
                                            <option>Washington</option>
                                        </select>
                                    </div>

                                    <!-- Date -->
                                    <div class="form-group">
                                        <label>Date:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#reservationdate" />
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label>choose any one:</label>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="cow" name="animal" checked>
                                            <label for="cow">Cow</label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="buffalo" name="animal">
                                            <label for="buffalo">Buffalo</label>
                                        </div>
                                    </div>

                                    <!-- radio -->
                                    <div class="form-group clearfix">
                                        <label>choose any one:</label>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="morining" name="time" checked>
                                            <label for="morining">Morning</label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="evening" name="time">
                                            <label for="evening">Evening</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="milkQuantity">Milk Quantity (liters):</label>
                                        <input type="number" class="form-control" id="milkQuantity" name="milkQuantity"
                                            min="0" step="0.01" placeholder="Enter milk quantity in liters"
                                            required>
                                    </div>



                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
