<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>project-request</title>
</head>

<body>

    <?php include 'header.php' ?>

    <div class="content">
        <button class="b1 btn btn-success"> + เพิ่มคำขอพัฒนา</button>
        <h4 class="table-req-head">คำขอพัฒนาซอฟท์แวร์</h4>
        <div class="query-req">
            <form action="" method="POST" class="query-req-form">
                <div class="form-check">
                    <label class="form-check-label" for="query-software-all">
                        <input class="form-check-input" type="radio" name="query-software" id="query-software-all" value="all" checked>
                        คำขอทั้งหมด
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="query-software-mine">
                        <input class="form-check-input" type="radio" name="query-software" id="query-software-mine" value="mine">
                        คำขอของฉัน
                    </label>
                </div>
                <button type="submit" class="btn btn-success">ค้นหา</button>
            </form>
        </div>
        <div class="table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>วันที่ขอ</th>
                        <th>ชื่อระบบ</th>
                        <th>ผู้ขอ</th>
                        <th>สถานะคำขอ</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>00/00/25xx</td>
                        <td>ระบบ</td>
                        <td>นาย ก</td>
                        <td>รอหัวหน้าแผนก</td>
                        <td><button class="btn btn-primary" type="button">แสดงรายละเอียด</button></td>
                    </tr>
                    <tr>
                        <td>00/00/25xx</td>
                        <td>ระบบ</td>
                        <td>นาย ก</td>
                        <td>รอหัวหน้าแผนก</td>
                        <td><button class="btn btn-primary" type="button">แสดงรายละเอียด</button></td>
                    </tr>
                    <tr>
                        <td>00/00/25xx</td>
                        <td>ระบบ</td>
                        <td>นาย ก</td>
                        <td>รอหัวหน้าแผนก</td>
                        <td><button class="btn btn-primary" type="button">แสดงรายละเอียด</button></td>
                    </tr>
                    <tr>
                        <td>00/00/25xx</td>
                        <td>ระบบ</td>
                        <td>นาย ก</td>
                        <td>รอหัวหน้าแผนก</td>
                        <td><button class="btn btn-primary" type="button">แสดงรายละเอียด</button></td>
                    </tr>
                    <tr>
                        <td>00/00/25xx</td>
                        <td>ระบบ</td>
                        <td>นาย ก</td>
                        <td>รอหัวหน้าแผนก</td>
                        <td><button class="btn btn-primary" type="button">แสดงรายละเอียด</button></td>
                    </tr>
                    <tr>
                        <td>00/00/25xx</td>
                        <td>ระบบ</td>
                        <td>นาย ก</td>
                        <td>รอหัวหน้าแผนก</td>
                        <td><button class="btn btn-primary" type="button">แสดงรายละเอียด</button></td>
                    </tr>
                    <tr>
                        <td>00/00/25xx</td>
                        <td>ระบบ</td>
                        <td>นาย ก</td>
                        <td>รอหัวหน้าแผนก</td>
                        <td><button class="btn btn-primary" type="button">แสดงรายละเอียด</button></td>
                    </tr>
                    <tr>
                        <td>00/00/25xx</td>
                        <td>ระบบ</td>
                        <td>นาย ก</td>
                        <td>รอหัวหน้าแผนก</td>
                        <td><button class="btn btn-primary" type="button">แสดงรายละเอียด</button></td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
    <footer>
        @@@ credit @@@
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>