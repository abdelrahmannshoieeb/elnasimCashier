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
            width: 75mm;
            margin: 0 auto;
        }

        .margin0 {
            margin: 0;
        }

        .invoice-header,
        .invoice-footer {
            text-align: center;
            margin-bottom: 10px;
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
            font-size: 12px;
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
    .no-print {
      display: none !important;
    }
  }
    </style>
</head>


@php
$id = request()->segment(2);
$CustomerBonnd = \App\Models\CustomerBonnd::find($id);


$user = \App\Models\User::find($CustomerBonnd->user_id);
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

    <div class="invoice-header" style="text-align: right; font-weight: bold;">
        <span>المسلسل: {{ convertToArabicDigits($CustomerBonnd->id) }}</span>
        <span style="float: left;">اسم العميل: {{ $CustomerBonnd->customerName ?? $CustomerBonnd->customer->name }}</span>
    </div>

    <div class="invoice-header" style="text-align: right;">
        <span>التاريخ: {{ convertToArabicDigits($CustomerBonnd->created_at->format('y-m-d')) }}</span>
        <span style="float: left;">
            {{ convertToArabicDigits($CustomerBonnd->created_at->addHours(2)->format('h:i')) }}
            {{ $CustomerBonnd->created_at->format('A') === 'AM' ? 'صباحا' : 'مساء' }}
        </span>
    </div>

    <div class="invoice-header" style="text-align: right; font-weight: bold;">
        <span>اسم الكاشير:  عبد الرحمن</span>
    </div>








    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">{{ convertToArabicDigits($CustomerBonnd->value + $CustomerBonnd->customer->balance) }}</span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1;">حساب قديم</span>
        </div>
    </div>

    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">{{ convertToArabicDigits($CustomerBonnd->value) }}</span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1;">تنزيل نقدي</span>
        </div>
    </div>

    @if ($CustomerBonnd->customer->balance > 0)
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">{{ convertToArabicDigits($CustomerBonnd->customer->balance) }}</span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1;"> المتبقى له</span>
        </div>
    </div>
    @endif
    @if ($CustomerBonnd->customer->balance < 0)
        <div>
        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin: 2px 0;">
            <span style="text-align: left; flex: 1;">
                {{ convertToArabicDigits(abs($CustomerBonnd->customer->balance)) }}
            </span>
            <span style="margin: 0 20px; flex: 1;"></span>
            <span style="text-align: right; flex: 1;"> المتبقى علية</span>
        </div>
        </div>
        @endif


        <hr class="margin0">
        <p class="text-center margin0">السعر شامل الضريبة</p>
        <p class="text-center font-bold margin0">العنوان: هلية - ببا - بني سويف</p>
        <p class="text-center font-bold margin0">رقم الهاتف: 01115179392</p>
        <p class="text-center" style="font-size: 14px;">
            01012620529 للبرمجيات Nexoria <strong>تم التطوير بواسطة</strong>
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