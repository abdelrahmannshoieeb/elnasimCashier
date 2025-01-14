<main class="flex-grow p-6">
    <div class="grid lg:grid-cols-4 gap-6">
        <div class="lg:col-span-3 space-y-6">
            <div class="card p-6">
                <div class="flex justify-between items-center mb-4">
                    <p class="card-title">تعديل بيانات المورد</p>
                    <div class="inline-flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 w-9 h-9">
                        <i class="mgc_transfer_line"></i>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="">
                        <label for="project-name" class="mb-2 block " style="font-weight:600;">اسم المورد</label>
                        <input style="font-weight:600;" type="email" id="project-name" class="form-input" value="{{ $supplier->name }}" placeholder="ادخل اسم المورد" aria-describedby="input-helper-text" wire:model="name">
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="">
                        <label for="project-name" class="mb-2 block " style="font-weight:600;">عنوان المورد</label>
                        <input style="font-weight:600;" type="email" id="project-name" class="form-input" value="{{ $supplier->address }}" placeholder="ادخل عنوان المورد" aria-describedby="input-helper-text" wire:model="addrees">
                        @error('addrees') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="">
                        <label for="project-description" class="mb-2 block" style="font-weight:600;">ملاحظات <span class="text-red-500">*</span></label>
                        <textarea id="project-description" class="form-input" rows="8" wire:model="notes"></textarea>
                        @error('notes') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>


                    <div class="grid md:grid-cols-4 gap-3">
                        <div class="">
                            <label for="due-date" class="mb-2 block" style="font-weight:600;"> رقم هاتف </label>
                            <input type="text" id="due-date" class="form-input" wire:model="phone" value="{{ $supplier->phone }}"></input>
                            @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 mt-5">
            <div class="flex justify-end gap-3">
                <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-red-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none">
                    Cancle
                </button>
                <button
                    wire:click="save"
                    type="button" class="inline-flex items-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none">
                    Save
                </button>
            </div>
        </div>


    </div>
    @if (session()->has('message'))
    <div class="bg-success/25 text-success text-center text-xl rounded-md p-4 mt-5" role="alert" style="width: 75%;">
        <span class="font-bold text-lg"></span>    {{ session('message') }}
    </div>
    @endif
</main>