@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5">

        @auth
            <!-- Summary Cards -->
            <div class="row text-center mb-4">
                <div class="col">
                    <div class="card bg-all text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'คำขอทั้งหมด' }}</h5>
                            <p class="card-text fs-4">{{ isset($software) ? $software->count() : 0 }}</p>
                            <p class="card-text">รายการ</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-dh text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'รอหัวหน้าแผนกอนุมัติ' }}</h5>
                            <p class="card-text fs-4">
                                {{ isset($software) ? $software->where('status', 'pending')->count() : 0 }}</p>
                            <p class="card-text">รายการ</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-ad text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'รอหัวหน้าทีมพัฒนาอนุมัติ' }}</h5>
                            <p class="card-text fs-4">
                                {{ isset($software) ? $software->where('status', 'approved by DH')->count() : 0 }}</p>
                            <p class="card-text">รายการ</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-wait text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'คำขอที่รอคิวพัฒนา' }}</h5>
                            <p class="card-text fs-4">{{ isset($software) ? $software->where('status', 'queued')->count() : 0 }}
                            </p>
                            <p class="card-text">รายการ</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-prog text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'คำขอที่กำลังพัฒนา' }}</h5>
                            <p class="card-text fs-4">
                                {{ isset($software) ? $software->where('status', 'in progress')->count() : 0 }}</p>
                            <p class="card-text">รายการ</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-com text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'คำขอที่พัฒนาเสร็จสิน' }}</h5>
                            <p class="card-text fs-4">
                                {{ isset($software) ? $software->where('status', 'completed')->count() : 0 }}</p>
                            <p class="card-text">รายการ</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-can text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'คำขอที่ถูกยกเลิก' }}</h5>
                            <p class="card-text fs-4">
                                {{ isset($software) ? $software->where('status', 'canceled')->count() : 0 }}</p>
                            <p class="card-text">รายการ</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="row">
                @if (isset($software) && !$software->isEmpty())
                    @foreach (['queued' => 'รอคิวพัฒนา', 'in progress' => 'กำลังพัฒนา', 'completed' => 'พัฒนาเสร็จสิ้น', 'canceled' => 'ยกเลิก'] as $status => $label)
                        <div class="col-lg-3 mb-3">
                            <div class="card">
                                <div class="card-header bg-success text-white text-center">
                                    {{ $label }}
                                    {{ isset($software) ? $software->where('status', $status)->count() : 0 }} รายการ
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-borderless m-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 100px">ลำดับ</th>
                                                <th class="text-center">ชื่อระบบ</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="card-body  table-container p-0">
                                    <table class="table table-borderless table-hover m-0">
                                        <tbody>
                                            @foreach ($software->where('status', $status) as $index => $item)
                                                <tr>
                                                    <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $item->software_name }}</td>
                                                </tr>
                                            @endforeach
                                            @if ($software->where('status', $status)->isEmpty())
                                                <tr>
                                                    <td colspan="2" class="text-center">ไม่มีข้อมูล</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">ไม่มีข้อมูล</p>
                @endif
            </div>
        @else
            <!-- Guest Placeholder -->
            <div class="alert alert-warning text-center">
                กรุณาเข้าสู่ระบบเพื่อดูคำขอพัฒนาซอฟต์แวร์
            </div>
            <script>
                window.location.href = '{{ route('login') }}';
            </script>
        @endauth
    </div>
@endsection
