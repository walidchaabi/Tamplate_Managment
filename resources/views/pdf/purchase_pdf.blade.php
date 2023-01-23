<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{__('Purchase')}} _{{$purchase->reference}}</title>
      <link rel="stylesheet" href="{{asset('/print/pdfStyle.css')}}" media="all" />
   </head>

   <body>
      <header class="clearfix">
         <div id="logo">
         <img src="{{asset('/images/'.$setting['logo'])}}">
         </div>
         <div id="company">
            <div><strong> Date: </strong>{{$purchase->date}}</div>
            <div><strong> Numéro: </strong> {{$purchase->reference}}</div>
         </div>
         <div id="Title-heading">
             Achat  : {{$purchase->reference}}
         </div>
         </div>
      </header>
      <main>
         <div id="details" class="clearfix">
            <div id="client">
               <table class="table-sm">
                  <thead>
                     <tr>
                        <th class="desc">{{__('Supplier Info')}}</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>
                           <div><strong>Nom:</strong> {{$purchase->supplier->name}}</div>
                           <div><strong>ICE:</strong> {{$purchase['tax_number']}}</div>
                           <div><strong>Téle:</strong> {{$purchase['phone']}}</div>
                           <div><strong>Adresse:</strong>   {{$purchase['adress']}}</div>
                           <div><strong>{{__('Email')}}:</strong>  {{$purchase['email']}}</div>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="invoice">
               <table class="table-sm">
                  <thead>
                     <tr>
                        <th class="desc">{{__('Company Info')}}</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>
                           <div id="comp">{{settings()->company_name}}</div>
                           <div><strong>{{ __('Tax number') }}</strong> {{ settings()->company_tax }}</div>
                           <div><strong>Adresse:</strong>  {{settings()->company_address}}</div>
                           <div><strong>Téle:</strong>  {{settings()->company_phone}}</div>
                           <div><strong>{{__('Email')}}:</strong>  {{settings()->company_email}}</div>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div id="details_inv">
            <table class="table-sm">
               <thead>
                  <tr>
                     <th>{{__('PRODUCT')}}</th>
                     <th>{{__('UNIT COST')}}</th>
                     <th>{{__('QUANTITY')}}</th>
                     <th>{{__('DISCOUNT')}}</th>
                     <th>{{__('TAX')}}</th>
                     <th>{{__('TOTAL')}}</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($details as $detail)    
                  <tr>
                     <td>
                        <span>{{$detail->code}} ({{$detail->name}})</span>
                           @if($detail['is_imei'] && $detail['imei_number'] !==null)
                              <p>IMEI/SN : {{$detail['imei_number']}}</p>
                           @endif
                     </td>
                     <td>{{$detail['cost']}} </td>
                     <td>{{$detail->quantity}}/{{$detail['unit_purchase']}}</td>
                     <td>{{$detail['DiscountNet']}} </td>
                     <td>{{$detail['taxe']}} </td>
                     <td>{{$detail->total_amount}} </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         <div id="total">
            <table>
               <tr>
                  <td>{{__('Order Tax')}}</td>
                  <td>{{$purchase['TaxNet']}} </td>
               </tr>
               <tr>
                  <td>{{__('Discount')}}</td>
                  <td>{{$purchase['discount']}} </td>
               </tr>
               <tr>
                  <td>{{__('Shipping')}}</td>
                  <td>{{$purchase['shipping']}} </td>
               </tr>
               <tr>
                  <td>{{__('Total')}}</td>
                  <td>{{$symbol}} {{$purchase['GrandTotal']}} </td>
               </tr>

               <tr>
                  <td>{{__('Paid Amount')}}</td>
                  <td>{{$symbol}} {{$purchase['paid_amount']}} </td>
               </tr>

               <tr>
                  <td>{{__('Due')}}</td>
                  <td>{{$symbol}} {{$purchase['due']}} </td>
               </tr>
            </table>
         </div>
         <div id="signature">
            @if (settings()->invoice_footer !== null)
                <p>{{ settings()->invoice_footer }}</p>
            @endif
         </div>
      </main>
   </body>
</html>