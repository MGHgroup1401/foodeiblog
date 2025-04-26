@extends('admin.layout.master')
@section('title', 'افزودن دسته بندی - نوا بلاگ')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">افزودن دسته بندی</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <form action="{{ route('admin.category.store') }}" method="post">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">دسته بندی جدید</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name">عنوان</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
                                        @error('name') <div class="text-danger"><p>{{ $message }}</p></div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="parent_id">دسته بندی والد</label>
                                        <select name="parent_id" id="parent_id" class="form-select" data-choices data-selecttext="کلیک برای انتخاب">
                                            <option value="">انتخاب دسته بندی والد</option>
                                            @foreach($categories as $parent)
                                                <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>{{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_id') <div class="text-danger"><p>{{ $message }}</p></div> @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">توضیحات</label>
                                        <textarea name="description" id="description" cols="5" rows="5" class="form-control">{{ old('description') }}</textarea>
                                        @error('description') <div class="text-danger"><p>{{ $message }}</p></div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.category.index') }}" class="btn btn-outline-secondary"><i class="bi bi-chevron-left me-2"></i>بازگشت</a>
                            <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i>ذخیره</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
        );
        const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
        );
        document.querySelectorAll("select[data-choices]").forEach((element) => {
        let config = {};
        if (element.dataset.selecttext !== "") {
        config.itemSelectText = element.dataset.selecttext;
        }
        new Choices(element, config);
        });
        document.querySelectorAll("input[data-taggable]").forEach((element) => {
        let config = {
        delimiter: ",",
        removeItemButton: true,
        };
        if (element.dataset.selecttext !== "") {
        config.addItemText = (value) => {
            return element.dataset.selecttext;
        };
        }
        new Choices(element, config);
        });
        function deleteItem(ele) {
        let url = ele.dataset.url;
        let title = ele.dataset.title;
        let token = ele.dataset.token;
    
        JSAlert.confirm(
        "آیا از حذف این مورد اطمینان دارید؟",
        "حذف " + title,
        JSAlert.Icons.Deleted,
        "تائید",
        "لغو"
        ).then(function (result) {
        if (result) {
            $.ajax({
                url: url,
                method: "post",
                data: {
                    _token: token,
                    _method: "DELETE",
                },
                success: function (response) {
                    if (response.success === true) {
                        JSAlert.alert(
                            response.message,
                            "پیام",
                            JSAlert.Icons.Success,
                            "بستن"
                        ).then(function () {
                            setTimeout(function () {
                                window.location.reload();
                            }, 500);
                        });
                    } else {
                        JSAlert.alert(
                            response.message,
                            "خطا",
                            JSAlert.Icons.Failed,
                            "بستن"
                        );
                    }
                },
                error: function (error) {
                    notifier.show(
                        "خطا",
                        "مشکلی پیش آمده. مجدد سعی کنید",
                        "danger",
                        "",
                        4000
                    );
                },
            });
        }
        });
        }
        document.querySelectorAll("form").forEach(function (form) {
        form.addEventListener("keypress", function (event) {
        if (event.code === "Enter" || event.key === "Enter") {
            event.preventDefault();
        }
        });
        });
        function changeStatus(element) {
        let url = element.dataset.url;
        let token = element.dataset.token;
        let statusElement = document.querySelector('select#status');
        let spinner = document.querySelector('div#status_spinner');
        let status_form = document.querySelector('div#status_change');
        let status_badge = document.querySelector('td#status_badge');
    
        spinner.classList.remove('d-none');
        status_form.classList.add('d-none');
    
        $.ajax({
        url: url,
        method: "post",
        data: {
            _token: token,
            status: statusElement.value
        },
        success: function (response) {
            spinner.classList.add('d-none');
            status_form.classList.remove('d-none');
            if (response.success === true) {
                status_badge.innerHTML = '';
                status_badge.innerHTML = `<span class="badge bg-${response.color}  py-2 px-3">${response.title}</span>`;
            } else {
                JSAlert.alert(response.message, "خطا", JSAlert.Icons.Failed, "بستن");
            }
        },
        error: function (error) {
            spinner.classList.add('d-none');
            status_form.classList.remove('d-none');
            notifier.show("خطا", "مشکلی پیش آمده. مجدد سعی کنید", "danger", "", 4000);
        },
        });
        }
        document.querySelectorAll('.btn-gen-passw').forEach((element) => {
        element.addEventListener('click', function (event) {
        let upper = true,
            nums = true,
            special = true,
            len = 10;
        const lower = "abcdefghijklmnopqrstuvwxyz",
            upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
            numChars = "0123456789",
            specialChars = "!@#$%^&*()-_=+[]{}|;:,.<>?";
        let chars = lower;
        if (upper) chars += upperChars;
        if (nums) chars += numChars;
        if (special) chars += specialChars;
        let pass = "";
        for (let i = 0; i < len; i++) {
            const randIdx = Math.floor(Math.random() * chars.length);
            pass += chars[randIdx];
        }
        document.querySelector('#password').value = pass;
        });
        });
    
    </script>
@endsection
