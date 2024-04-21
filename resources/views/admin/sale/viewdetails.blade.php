@php 
    use App\Util; 
    $total_quantity = 0;
    $total_currency = 0
@endphp

<div class="row " style="margin-top:0px; padding:0;">
    <div class="col-md-12 col-sm-12 col-xs-12 asi-playlist-open-from" id="asi-playlist-open-from">
        <div class="row " style="margin-top:0px; padding:0;">
        @if(isset($sale) && $sale!=null) 
            <div  class="col-md-6 col-sm-6 col-xs-12 text-center">Khách Hàng: {{ $sale[0]->customer_name}} </div> 
            <div  class="col-md-6 col-sm-6 col-xs-12 text-center">Ngày Bán: {{ $sale[0]->date}}</div> 
        @else
            <div  class="col-md-6 col-sm-6 col-xs-12 text-center">Khách Hàng:# </div> 
            <div  class="col-md-6 col-sm-6 col-xs-12 text-center">Ngày Bán:#</div> 
        @endif
        
        </div>

        <div class="asi-table-container">
            <div class="table-responsive">
                <table id="grid-data-add-question" class="grid-data table table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th data-column-id="idx" data-style="max-width:20px;">#</th>
                            <th data-column-id="product_name" data-style="min-width:400px;" data-visible="false">Sản Phẩm</th>                            
                            <th data-column-id="package_name" data-style="min-width:100px;" data-visible="false" data-headerAlign="center" data-align="right">Loại Bao</th>
                            <th data-column-id="unit" data-style="min-width:100px;" data-visible="false" data-headerAlign="center" data-align="right">ĐVT</th>                           
                            <th data-column-id="price" data-style="max-width:100px; text-align:right;" data-visible="false" data-headerAlign="right" data-align="right">Giá</th>
                            <th data-column-id="quantity" data-style="min-width:100px; text-align:right;" data-visible="false" data-headerAlign="right" data-align="right">Số Lượng</th>
                            <th data-column-id="total" data-style="min-width:100px; text-align:right;" data-visible="false" data-headerAlign="right" data-align="right">Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(isset($data) && $data!=null)
                            @foreach ($data as $key => $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->product_name}}</td>                               
                                <td>{{$item->package_name}}</td>
                                <td>{{$item->unit}}</td>                               
                                <td style="text-align:right;">{{ Util::currency_format($item->price)}}</td>
                                <td style="text-align:right;">{{Util::quantity_format($item->quantity)}}</td>
                                <td style="text-align:right;">{{Util::currency_format($item->total)}}</td>
                            </tr>
                            @php
                                $total_quantity+=$item->quantity;
                                $total_currency+=$item->total;
                            @endphp
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="5" style="text-align:right; color:#0000ff; font-weight:bold;">Tổng</td>                            
                            <td style="text-align:right; color:#ff0000; font-weight:bold;">{{ Util::quantity_format($total_quantity)}}</td>
                            <td style="text-align:right; color:#ff0000; font-weight:bold;">{{Util::currency_format($total_currency)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    .form-group.required label:after {
        content: " *";
        color: red;
    }

    div.b {
        text-align: left;
    }
</style>