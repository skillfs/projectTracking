@extends('layouts.app')

@section('content')
    <div class="container">

        @auth
            <!-- Summary Cards -->
            <div class="row text-center mb-4">
                <div class="col">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'คำขอทั้งหมด' }}</h5>
                            <p class="card-text fs-4">{{ isset($software) ? $software->count() : 0 }}</p>
                            <p class="card-text">รายการ</p>
                        </div>
                    </div>
                </div>
                @foreach (['pending' => 'รอหัวหน้าแผนก', 'approved by DH' => 'รอหัวหน้าทีมพัฒนา', 'queued' => 'รอคิวพัฒนา', 'in progress' => 'กำลังพัฒนา', 'completed' => 'พัฒนาเสร็จสิ้น'] as $status => $label)
                    <div class="col">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">{{ $label }}</h5>
                                <p class="card-text fs-4">
                                    {{ isset($software) ? $software->where('status', $status)->count() : 0 }}</p>
                                <p class="card-text">รายการ</p>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                                    <table class="table table-bordered m-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">ลำดับ</th>
                                                <th class="text-center">ชื่อระบบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($software->where('status', $status) as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
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
