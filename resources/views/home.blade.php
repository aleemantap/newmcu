
@extends('layouts.app')
@section('title', 'Home')
@section('ribbon')
    <ul class="breadcrumbs pull-left">
        <li><a href="/home">Home</a></li>
        <li><span>Dashboard</span></li>
    </ul>

@endsection
@section('title', "Dashboard")
@section('content')

                <div class="row">
                    <!-- seo fact area start -->
                    <div class="col-lg-12 mt-5">
                        <div class="row">
                            <div class="col-md-3 mt-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg1">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon"><i class="fa fa-stethoscope"></i> Transactions</div>
                                            <h2>{{ number_format($totalTransaction,0,',','.') }}</h2>
                                        </div>
                                        <canvas id="seolinechart1" height="50"></canvas>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-3 mt-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg4">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon"><i class="fa fa-user"></i> Patient</div>
                                            <h2>{{ number_format($totalPatient,0,',','.') }}</h2>
                                        </div>
                                        <canvas id="seolinechart2" height="50"></canvas>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-3 mt-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg3">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon"><i class="fa fa-cubes"></i> Packet</div>
                                            <h2>{{ number_format($totalPacket,0,',','.') }}</h2>
                                        </div>
                                        <canvas id="seolinechart3" height="50"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-md-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg2">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon"><i class="fa fa-building"></i> Department</div>
                                            <h2>{{ number_format($totalDepartment,0,',','.') }}</h2>
                                        </div>
                                        <canvas id="seolinechart4" height="50"></canvas>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    
                   
                   
                    <div class="col-lg-8 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-5">
                                    <h4 class="header-title mb-0">Total Transaction Per Event Registration</h4>
                                    {{-- <select class="custome-select border-0 pr-3">
                                        <option selected="">Last 7 Days</option>
                                        <option value="0">Last 7 Days</option>
                                    </select> --}}
                                </div>
                                <div id="visitor_graph"></div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-lg-4 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Statistic By Age</h4>
                                <canvas id="seolinechart8" height="233"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-6">
                        <div class="statistic-section-title">Pemasukan vs Pengeluaran Obat <small class="text-success">Dalam 15 Hari Terakhir</small></div>
                        <div id="traffic-trend" style="width: 100%; height: 300px"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="statistic-section-title">Penyakit Teratas</div>
                        <div id="cctv-2" style="width: 100%; height: 300px"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div style="height: 30px"></div>
                    </div>
                </div> --}}
                <br/>
         
      
@endsection

