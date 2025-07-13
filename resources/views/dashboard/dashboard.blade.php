@extends('layouts.index')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Cow Milk -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info text-white">
                            <div class="inner">
                                @php
                                    $cowShares = $cowMilkSales * 2;
                                @endphp
                                <h3>{{ number_format($cowMilkSales, 2) }} L</h3>
                                <p>Cow Milk (This Year)</p>
                                <small>{{ number_format($cowShares, 2) }} Shares</small>
                            </div>
                            <div class="icon">
                                <i class="fas fa-hippo"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Cow Milk Revenue -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info text-white">
                            <div class="inner">
                                <h3>₹ {{ number_format($cowMilkRevenue, 2) }}</h3>
                                <p>Cow Milk Revenue (This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Buffalo Milk -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-teal text-white">
                            <div class="inner">
                                @php
                                    $buffaloShares = $buffaloMilkSales * 2;
                                @endphp
                                <h3>{{ number_format($buffaloMilkSales, 2) }} L</h3>
                                <p>Buffalo Milk (This Year)</p>
                                <small>{{ number_format($buffaloShares, 2) }} Shares</small>
                            </div>
                            <div class="icon">
                                <i class="fas fa-hippo"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Buffalo Milk Revenue -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-teal text-white">
                            <div class="inner">
                                <h3>₹ {{ number_format($buffaloMilkRevenue, 2) }}</h3>
                                <p>Buffalo Milk Revenue (This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success text-white">
                            <div class="inner">
                                <h3>₹ {{ number_format($totalRate, 2) }}</h3>
                                <p>Total Milk Revenue (This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Milk Weight (From Dairy) -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-gradient-indigo text-white">
                            <div class="inner">
                                <h3>{{ number_format($milkWeightFromDairy, 2) }} L</h3>
                                <p>Milk Weight (From Dairy)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-weight"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Dairy Total Amount -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-gradient-indigo text-white">
                            <div class="inner">
                                <h3>₹ {{ number_format($totalMilkRevenue, 2) }}</h3>
                                <p>Total Dairy Revenue (This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Ghee Sales -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning text-white">
                            <div class="inner">
                                <h3>{{ number_format($gheeSales, 2) }} Kg</h3>
                                <p>Ghee Sales (This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-hippo"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Ghee Revenue -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning text-white">
                            <div class="inner">
                                <h3>₹ {{ number_format($gheeRevenue, 2) }}</h3>
                                <p>Ghee Revenue (This Year)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>
                    </div>



                    <!-- Grand Total (Revenue + Dairy) -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-gradient-success text-white">
                            <div class="inner">
                                <h3>₹ {{ number_format($grandTotal, 2) }}</h3>
                                <p>Grand Total (Milk + Ghee + Dairy)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Count -->
                    <div class="col-lg-3 col-6">
                        <a href="{{ route('admin.customer_list') }}">
                            <div class="small-box bg-danger text-white">
                                <div class="inner">
                                    <h3>{{ $customerCount }}</h3>
                                    <p>Customers</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
