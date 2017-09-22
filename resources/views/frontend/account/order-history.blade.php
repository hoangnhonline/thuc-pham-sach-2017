@extends('frontend.layout')
@include('frontend.partials.meta')

@section('content')
<div class="content-shop left-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12 main-content">
                <div class="main-content-shop">                 
                    <h1 class="page-heading">
                        <span class="page-heading-title2">{{ trans('text.don-hang-cua-toi') }}</span>
                    </h1>
                               
                    <div class="dashboard-order have-margin">
                        <table class="table-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th style="text-align:center">
                                    <span class="hidden-xs hidden-sm hidden-md">{{ trans('text.ma-don-hang') }}</span>
                                    <span class="hidden-lg">{{ trans('text.ma-don-hang') }}</span>
                                </th>
                                <th>{{ trans('text.ngay-mua') }}</th>
                                <th>{{ trans('text.san-pham') }}</th>
                                <th style="text-align:right">{{ trans('text.tong-tien') }}</th>
                                <th style="text-align:center">
                                    <span class="hidden-xs hidden-sm hidden-md">{{ trans('text.trang-thai-don-hang') }}</span>
                                    <span class="hidden-lg">{{ trans('text.trang-thai') }}</span>
                                </th>
                                <th style="text-align:center">
                                    <span class="hidden-xs hidden-sm hidden-md">Trạng thái thanh toán</span>
                                    <span class="hidden-lg">Thanh toán</span>
                                </th>
                                <th>Chi tiết</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td style="text-align:center;"><a style="color:#ec1c24" href="{{ route('order-detail', $order->id)}}">{{ str_pad($order->id, 6, "0", STR_PAD_LEFT)}}</a></td>
                                    <td>{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                                    <td>                                        
                                    @foreach($order->order_detail()->get() as $detail)
                                    
                                    <p>{{ Helper::getName($detail->sp_id, 'product') }}</p>
                                    @endforeach
                                    </td>
                                    <td style="text-align:right">{{ number_format($order->tong_tien_vnd) }}</td>                                    
                                    <td style="text-align:center">
                                        <span class="order-status">
                                            {{ $status[$order->status] }}
                                        </span>
                                    </td>
                                    <td style="text-align:center">
                                        <span class="order-status">
                                            {{ $order->da_thanh_toan == 1  ? "Đã thanh toán" : "Chưa thanh toán" }}
                                        </span>
                                    </td>
                                    <td>
                                        <a style="color:#ec1c24" href="{{ route('order-detail', $order->id)}}">Xem chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Main Content Shop -->
            </div>
            @include('frontend.account.sidebar')
            
        </div>
    </div>
</div>

<style type="text/css">    
    .dashboard-order.have-margin {
        margin-bottom: 20px;
    }   
    table.table-responsive thead tr th {
        display: table-cell;
        padding: 8px;
        background: #f8f8f8;
        font-weight: 500;    
    }
    table.table-responsive tbody tr td{
        font-size: 14px !important;
    }
</style>
<div class="clearfix"></div>
@endsection