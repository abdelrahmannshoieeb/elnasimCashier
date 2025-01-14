<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Invoice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            width: 80mm;
            margin: 0 auto;
            display: flex;
            /* Enable Flexbox */
            align-items: center;
            /* Center vertically */
            height: 100vh;
            /* Full viewport height */
            text-align: center;
            /* Center text */
            flex-direction: column;
        }

        .margin0 {
            margin: 0;
        }

        .invoice-header,
        .invoice-footer {
            text-align: center;
            margin-bottom: 5px;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 16px;
        }

        .invoice-header p {
            margin: 0;
            font-size: 12px;
        }

        .invoice-details,
        .invoice-items {
            margin-bottom: 10px;
        }

        .invoice-details p,
        .invoice-items p {
            margin: 5px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }

        th {
            text-align: left;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                /* Ensure the width is 100% of the printable area */
                height: 100%;
                /* Full height */
            }

            @page {
                margin: 0;
                /* Remove default page margins */
            }

            table {
                width: 100%;
                /* Ensure tables use the full width */
            }
        }

        @media print {
    .no-print {
      display: none !important;
    }
  }
    </style>
</head>


@php
$id = request()->segment(2);
$invoice = \App\Models\SupplierInvoice::find($id);
@endphp
@php
// Helper functions for Arabic numeral conversion
if (!function_exists('convertToArabicDigits')) {
function convertToArabicDigits($number)
{
$arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
return str_replace(range(0, 9), $arabicDigits, $number);
}
}

\Carbon\Carbon::setLocale('ar'); // Set locale for Carbon
@endphp

<body>
<a href="{{ route('addInvoice') }}" style=" font-size: larger; font-weight: bolder; position: absolute; top: 30px; left: 30px; background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;" class="no-print"> العودة للفواتير</a>

    <h1 class="text-center" style="font-weight: bolder;">النسيم للاعلاف</h1>
    <h6 class="text-center" style="font-weight: bolder;">فاتورة توريدات</h6>



    <div class="invoice-header" style="text-align: right;">
        <span>التاريخ: {{ convertToArabicDigits($invoice->created_at->format('y-m-d')) }}</span>
        <span style="float: left;">
            {{ convertToArabicDigits($invoice->created_at->addHours(2)->format('h:i')) }}
            {{ $invoice->created_at->format('A') === 'AM' ? 'صباحا' : 'مساء' }}
        </span>
    </div>


    <div class="invoice-header" style="text-align: right; font-weight: bold;">
        <span>المسلسل: {{ convertToArabicDigits($invoice->id) }}</span>
        <span style="float: left;">اسم المورد: {{ $invoice->supplier->name }}</span>
    </div>

    <div class="invoice-header" style="text-align: right; font-weight: bold;">
        <span>اسم الكاشير: الحاج مبروك</span>
    </div>

    <div class="invoice-items">
        <table style="width: 100%; text-align: right; border-collapse: collapse; font-size: 14px; font-weight: bold; border: 2px solid black;">
            <thead>
                <tr>
                    <th style="border: 2px solid black; padding: 5px;" class="text-center">إجمالي السعر</th>
                    <th style="border: 2px solid black; padding: 5px;" class="text-center">سعر الصنف</th>
                    <th style="border: 2px solid black; padding: 5px;" class="text-center">الكمية</th>
                    <th style="border: 2px solid black; padding: 5px;" class="text-right">الصنف</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->supplier_invoice_items as $item)
                <tr>
                    <td style="border: 2px solid black; padding: 5px;" class="text-center ">
                        <strong>

                            {{ convertToArabicDigits($item->qty * $item->buyingPrice) }}
                        </strong>
                    </td>
                    <td style="border: 2px solid black; padding: 5px;" class="text-center">
                        <strong>

                            {{ convertToArabicDigits($item->buyingPrice) }}
                        </strong>
                    </td>
                    <td style="border: 2px solid black; padding: 5px; font_size:14px;" class="text-center">
                        <strong>
                            {{ convertToArabicDigits($item->qty) }}
                        </strong>
                    </td>
                    <td style="border: 2px solid black; padding: 5px; font_size:12px;" class="text-right">
                        {{ $item->product->name }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: 2px dashed black; padding: 5px;" class="text-center">
                        {{ convertToArabicDigits($invoice->total) }}
                    </td>
                    <td style="border: 2px dashed black; padding: 5px;" class="text-center"></td>
                    <td style="border: 2px dashed black; padding: 5px;" class="text-center">
                        {{ convertToArabicDigits($invoice->supplier_invoice_items->sum('qty')) }}
                    </td>
                    <td colspan="2" style="font-weight: bold; text-align: right; border: 2px dashed black; padding: 5px;">الإجمالي</td>
                </tr>
            </tfoot>
        </table>
    </div>


    @if ($invoice->discount)
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">{{ convertToArabicDigits($invoice->discount) }}</span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1;">الخصم</span>
        </div>
    </div>
    @endif

    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">{{ convertToArabicDigits($invoice->total) }}</span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1;">الاجمالي</span>
        </div>
    </div>

    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">{{ convertToArabicDigits($invoice->payedAmount) }}</span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1;">المدفوع</span>
        </div>
    </div>

    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">{{ convertToArabicDigits($invoice->still) }}</span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1;">المتبقي</span>
        </div>
    </div>


    @if ($invoice->customer && $invoice->customer->balance < 0)
        <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">{{ convertToArabicDigits(abs($invoice->customer->balance)) }}</span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1; width: 100%;"> ما زال متبقي عليه</span>
        </div>
        </div>
        @endif

        <hr class="margin0">
        <p class="text-center margin0">السعر شامل الضريبة</p>
        <p class="text-center font-bold margin0">العنوان: هلية - ببا - بني سويف</p>
        <p class="text-center font-bold margin0"> 01007210245_رقم الهاتف: 01115179392 </p>
        <p class="text-center" style="font-size: 14px;">
            01012620529 - 01094417139
        </p>
        <p class="text-center margin0" style="font-size: 14px;">
            للبرمجيات Nexoria تم التطوير بواسطة
        </p>

        <script>
            function printInvoice() {
                window.print();
            }
            window.onload = function() {
                setTimeout(printInvoice, 500);
            };
        </script>
</body>


</html>