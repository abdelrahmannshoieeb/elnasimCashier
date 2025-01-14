
<div class="overflow-x-auto">
    <div class="min-w-full inline-block align-middle">
        <div class="border rounded-lg divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
            <div class="py-3 px-4 d-flex">
                <div class="relative max-w-l flex items-center">
                    <input
                        type="text"
                        name="table-with-pagination-search"
                        id="table-with-pagination-search"
                        class="form-input ps-11 font-bold"
                        placeholder="ابحث باسم المورد"
                        wire:model="search">

                    <button type="button" wire:click="thesearch" class="btn bg-info text-white" style="margin:10px">ابحث</button>
                    <button type="button" wire:click="viewAll" class="btn bg-dark text-white" style="margin:10px"> الكل</button>
                    <div style="width: 230px;" x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button" class="py-2 px-3 inline-flex bg-success text-white justify-center items-center text-sm gap-2 rounded-md font-medium shadow-sm align-middle transition-all">
                            فلتر حسب نوع السند <i class="mgc_down_line text-base"></i>
                        </button>

                        <div x-show="open" @click.outside="open = false" class="absolute mt-2 z-50 bg-white border shadow-md rounded-lg p-2 dark:bg-slate-800 dark:border-slate-700 transition-all duration-300">
                            <a wire:click="forhim; open = false"
                                class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                سندات الاضافة
                            </a>
                            <a wire:click="onhim; open = false"
                                class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                سندات السحب
                            </a>
                            <a wire:click="empty; open = false"
                                class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                الرصيد فارغ
                            </a>
                        </div>
                    </div>
                    <div style="width: 230px;" x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button" class="py-2 px-3 inline-flex bg-success text-white justify-center items-center text-sm gap-2 rounded-md font-medium shadow-sm align-middle transition-all">
                            فلتر حسب طريقة الدفع <i class="mgc_down_line text-base"></i>
                        </button>

                        <div x-show="open" @click.outside="open = false" class="absolute mt-2 z-50 bg-white border shadow-md rounded-lg p-2 dark:bg-slate-800 dark:border-slate-700 transition-all duration-300">
                            <a wire:click="cheque; open = false"
                                class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                شيك
                            </a>
                            <a wire:click="credit; open = false"
                                class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                كريدت
                            </a>
                            <a wire:click="cash; open = false"
                                class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                نقدي
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <div class="overflow-x-auto">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 class=" overflow-x-auto"">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-center" style="font-size: larger; font-weight: bolder">معرف السند</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-center" style="font-size: larger; font-weight: bolder">اسم المورد</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-center" style="font-size: larger; font-weight: bolder">قيمة السند</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-left" style="font-size: larger; font-weight: bolder">نوع السند </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-center" style="font-size: larger; font-weight: bolder">ملاحظات </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-center" style="font-size: larger; font-weight: bolder">طريقة الدفع </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-center" style="font-size: larger; font-weight: bolder">الرصيد</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-center" style="font-size: larger; font-weight: bolder">العمليات</th>

                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 overflow-x-auto  style="width: 99%; >
                            @foreach($SupplierBonds as $SupplierBond)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200 text-center">{{ $SupplierBond->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 text-center" style="font-size: larger; font-weight: bolder">
                                    <li> <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">{{ $SupplierBond->supplier->name }}</span> </li>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 text-center" style="font-size: larger; font-weight: bolder">{{ $SupplierBond->value }}</td>
                                @if ($SupplierBond->type == 'add')
                                <td>
                                    <li> <span  class=" gap-1.5 py-1.5 px-3  rounded-full text-bold font-medium bg-green-100 text-green-800">زيادة</span> </li>
                                </td>
                                @else
                                <td>
                                    <li> <span  class=" gap-1.5 py-1.5 px-3 rounded-full text-bold font-medium bg-red-100 text-red-800">نقصان</span> </li>
                                </td>
                                @endif
                                @if ($SupplierBond->notes)
                                <td class="px-6 py-4 whitespace-nowrap text-bold text-gray-800 dark:text-gray-200 text-center" style="font-size: larger; font-weight: bolder;">{{ $SupplierBond->notes }}</td>
                                @else
                                <td>
                                    <li> <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800">لا يوجد عنوان</span> </li>
                                </td>
                                @endif
                                @if ($SupplierBond->method == 'cash')
                                <td class="px-6 py-4 whitespace-nowrap text-boldtext-gray-800 dark:text-gray-200 text-center" style="font-size: larger; font-weight: bolder;">
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full font-medium bg-red-500 text-white text-bold">كاش</span></td>
                                @elseif($SupplierBond->method == 'credit')
                                <td class="px-6 py-4 whitespace-nowrap text-bold text-gray-800 dark:text-gray-200 text-center" style="font-size: larger; font-weight: bolder;">
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full font-medium bg-green-500 text-white text-bold">كريدت</span></td>
                                @else
                                <td class="px-6 py-4 whitespace-nowrap text-boldtext-gray-800 dark:text-gray-200 text-center" style="font-size: larger; font-weight: bolder;">
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full font-medium bg-primary -500 text-white text-bold">شيك</span></td>
                               
                                @endif
                             
                              
                             
                                <td class="px-6 py-4 whitespace-nowrap text-bold text-gray-800 dark:text-gray-200 text-center" style="font-size: larger; font-weight: bolder">
                                    <li> <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">{{ $SupplierBond->supplier->balance }}</span> </li>
                                </td>
                               
                               
                              
                               
                                <td class="px-6 py-4 whitespace-nowrap text-end text-bold font-medium">
                                    <a class="text-danger hover:text-sky-700 mt-5 " href="#" style="font-size: larger; font-weight: bolder;" wire:click="delete({{$SupplierBond->id }})">مسح</a><br>
                                    <a class="text-primary hover:text-sky-700" href="{{ route('supplierPrinter', $SupplierBond->id) }}" style="font-size: larger; font-weight: bolder">تعديل</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>