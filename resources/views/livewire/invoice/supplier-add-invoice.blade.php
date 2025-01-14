<main class="flex-grow p-6">
    <div class="grid lg:grid-cols-6 gap-6">
        <div class="lg:col-span-4 space-y-6">
            <div class="card p-6">
                <h3 class="card-title font-bold mb-4" style="font-size: 26px;"> انشاء فاتورة للمورد</h3>
                <div class="grid md:grid-cols-2 gap-3">
                    <!-- Customer Selection -->
                    <div class="relative max-w-l flex items-center gap-3 mb-6">
                        <!-- Search Input -->
                        <input
                            type="text"
                            id="search-customer"
                            class="form-input ps-11"
                            placeholder="ابحث عن مورد"
                            wire:model.live.500ms="searchSupplier">
                        <label
                            for="search-customer"
                            style="font-size: 18px; text-align: center;">
                            اضغط على المورد لبدا الفاتورة
                        </label>
                    </div>

                    <!-- Supplier List -->
                    @if ($searchSupplier && $suppliers->isNotEmpty())
                    <div class="overflow-x-auto mb-6">
                        <div class="min-w-full inline-block align-middle">
                            <ul
                                style="max-height: 10rem; overflow-y: auto;"
                                class="max-w-xs flex flex-col border border-gray-200 rounded-lg dark:border-gray-700">
                                @foreach ($suppliers as $supplier)
                                <li
                                    wire:click="selectedCustomer({{ $supplier->id }})"
                                    style="cursor: pointer;"
                                    class="inline-flex items-center gap-x-2 py-2.5 px-4 text-sm font-medium bg-white border-b text-gray-800 hover:bg-gray-100 last:border-b-0 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                    {{ $supplier->name }}
                                    ({{ $supplier->balance }})
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @elseif($searchSupplier && $suppliers->isEmpty())
                    <!-- No Results Found -->
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        لا توجد نتائج لمورد بهذا الاسم
                    </div>
                    @endif

                </div>
                @if ($showButtons)
                <br>
                <div class="grid md:grid-cols-4 gap-3 mb-6 w-full">
                    <div>
                        <label class="text-gray-800 text-sm font-medium mb-2 block">المبلغ المدفوع</label>
                        <input type="number" class="form-input" wire:model="payedAmount" placeholder="{{ $payedAmount }}">
                    </div>
                    <div>
                        <label class="text-gray-800 text-sm font-medium mb-2 block">ملاحظات</label>
                        <textarea type="text" class="form-input" wire:model="notes"> </textarea>
                    </div>
                    <div>
                        <label class="text-gray-800 text-sm font-medium mb-2 block">خصم</label>
                        <input type="number" class="form-input" wire:model="discount">
                    </div>
                </div>

                <!-- Product Table -->
                <table class="w-full  border-gray-300 mb-6" style="background-color:rgb(234, 244, 246); border-radius: 10px">
                    <thead>
                        <tr>
                            <th class=" border-gray-300 px-4 py-2">اسم المنتج</th>
                            <th class=" border-gray-300 px-4 py-2">الكمية</th>
                            <th class=" border-gray-300 px-4 py-2">السعر</th>
                            <th class=" border-gray-300 px-4 py-2">الإجمالي</th>
                            <th class=" border-gray-300 px-4 py-2">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $item['name'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="number"
                                    class="form-input"
                                    value="{{ $item['quantity'] }}"
                                    id="quantity-{{ $index }}"> <!-- Unique ID to target the value -->
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item['calculated_price'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ (int)$item['quantity'] * (float)$item['calculated_price'] }}
                            </td>

                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <button
                                    class="btn bg-danger text-white"
                                    wire:click="removeItem({{ $index }})">
                                    حذف
                                </button>
                                <button
                                    class="btn bg-info text-white"
                                    wire:click="updateQuantity({{ $index }}, document.getElementById('quantity-{{ $index }}').value)">
                                    تحديث الكمية
                                </button>
                            </td>
                        </tr>

                        @endforeach
                        <tr>
                            <td class="px-4 py-2 font-bold" colspan="3">الإجمالي</td> <!-- Merge cells and bold text -->
                            <td class="px-4 py-2 text-right">
                                {{ collect($items)->sum(function ($item) {
        return (float)$item['quantity'] * (float)$item['calculated_price'];
    }) }}
                            </td>

                        </tr>


                    </tbody>
                </table>

                <div class="flex justify-end mt-4">
                    <button class="btn bg-green-500 text-white" wire:click="addItem">أضف المنتج</button>
                </div>
                @error('items')
                <p class="text-danger text-sm mt-2">اضف منتج لبدا الفاتورة</p>
                @enderror
                <div class="grid md:grid-cols-3 gap-3">
                    <!-- Search Product Section -->
                    <div>
                        <!-- Product Search Input -->
                        <label class="text-gray-800 text-sm font-medium mb-2 block">اسم المنتج</label>
                        <input
                            type="text"
                            id="search-product"
                            class="form-input"
                            placeholder="ابحث عن منتج"
                            wire:model.live.500ms="search">

                        <!-- Conditional Rendering for Search Results -->
                        @if ($search && $products->isNotEmpty())
                        <div class="overflow-x-auto m-6">
                            <div class="min-w-full inline-block align-middle">
                                <ul
                                    style="max-height: 10rem; overflow-y: auto;"
                                    class="max-w-xs flex flex-col border border-gray-200 rounded-lg dark:border-gray-700">
                                    @foreach ($products as $product)
                                    <li
                                        wire:click="selectProduct({{ $product->id }})"
                                        style="cursor: pointer;"
                                        class="inline-flex items-center gap-x-2 py-2.5 px-4 text-sm font-medium bg-white border-b text-gray-800 hover:bg-gray-100 last:border-b-0 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                        {{ $product->name }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @elseif ($search && $products->isEmpty())
                        <!-- No Results Found -->
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            لا توجد نتائج لمنتج بهذا الاسم
                        </div>
                        @else
                        <!-- Idle State -->
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            ابحث عن منتج
                        </div>
                        @endif
                    </div>


                    <!-- Quantity Section -->
                    <div>
                        <label class="text-gray-800 text-sm font-medium mb-2 block">الكمية</label>
                        <input type="number" class="form-input" wire:model="newItem.quantity">
                    </div>

                    <!-- Sell Price Section -->
                    @if ($selectedProduct)
                    <div>
                        <label class="text-gray-800 text-sm font-medium mb-2 block">اختر السعر</label>
                        <select class="form-input" wire:model="sell_price">
                            @if ($selectedProduct)
                            @if ($selectedProduct->itemStock > 0)
                            <option value="{{ $selectedProduct->buying_price }}">سعرالشراء  ({{ $selectedProduct->buying_price }})</option>
                            @else
                            @foreach ($selectedProduct->stock as $stock)
                            <option value="{{ $stock->price }}">
                                {{ __(' نوع المخزن') }} {{ $stock->type }} ({{ __(' سعر') }}: {{ $stock->price }})
                            </option>
                            @endforeach
                            @endif
                            @endif
                        </select>
                    </div>
                    @endif


                    @if (session()->has('quantityError'))
                    <div class="bg-danger/25 text-dark text-center text-xl rounded-md p-4 mt-5" role="alert" style="width: 75%;">
                        <span class="font-bold text-lg"></span> {{ session('quantityError') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-3 mt-5">
        <div class="flex justify-end gap-3">
            <a href="{{ route('addInvoice') }}" type="button" class="inline-flex items-center rounded-md border border-transparent bg-red-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none">
                البدء في فاتورة جديدة
            </a>
            @if ($items)
            <button
                style="cursor: pointer;"
                wire:click="saveInvoice"
                type="button"
                id="redirectButton"
                class="inline-flex items-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none">
                طباعة وحفظ الفاتورة
            </button>
            <button
                style="cursor: pointer;"
                wire:click="totalyPaid"
                type="button"
                id="redirectButton"
                class="inline-flex items-center rounded-md border border-transparent bg-gray-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-500 focus:outline-none">
                الفاتورة مدفوعة بالكامل
            </button>
            @else
            <p class="text-gray-500 " style="font-size: 20px;">اضف عميل ومنتجات لحفظ الفاتورة</p>
            @endif
            @if ($invoice)
            <a
                href="{{ route('supplierPrinter', $invoice->id) }}"
                type="button" class="inline-flex items-center rounded-md border border-transparent bg-indigo-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none">
                طباعة
            </a>
            @endif
        </div>
    </div>
    @else
    <div class="lg:col-span-3 mt-5">
        <div class="flex justify-end gap-3">
            <button
                wire:click="continueInvoice(true)"
                type="button" class="inline-flex items-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none">
                استمرار
            </button>
            <div class="flex justify-end gap-3">
                <button
                    wire:click="continueInvoice(false)"
                    type="button" class="inline-flex items-center rounded-md border border-transparent bg-red-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none">
                    فاتورة جديدة
                </button>
                <p class="text-gray-500 " style="font-size: 20px;">العميل متبقى عليه اموال هل تريد الاستمرار في عمل الفاتورة؟</p>
            </div>
        </div>
        @endif



    </div>
    @if (session()->has('message'))
    <div class="bg-success/25 text-success text-center text-xl rounded-md p-4 mt-5" role="alert" style="width: 75%;">
        <span class="font-bold text-lg"></span> تم الحفظ بنجاح
    </div>
    @endif
    @if (session()->has('balance'))
    <div class="bg-warning/25 text-success text-center text-xl rounded-md p-4 mt-5" role="alert" style="width: 75%;">
        <span class="font-bold text-lg"></span> {{ session('balance') }}
    </div>
    @endif

</main>

<script src="https://cdn.jsdelivr.net/npm/livewire-vue/livewire.js"></script>