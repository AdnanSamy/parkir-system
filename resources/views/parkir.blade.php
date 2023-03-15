<!DOCTYPE html>
<html lang="en">

@include('head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/logout" role="button">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Parkir System</span>
        </a>

        @include('tree')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="card p-2">
                    <div class="row m-2">
                        <div class="col-4">
                            <input type="text" id="dateRange" class="form-control">
                        </div>
                        <button class="btn btn-primary ml-auto" id="btnNew">New</button>
                    </div>
                    <table class="table table-border mt-2" id="main_table">
                        <thead class="bg-dark">
                            <th>No.</th>
                            <th>Kode Unik</th>
                            <th>Nomor Polisi</th>
                            <th>Waktu Masuk</th>s
                            <th>Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <div class="modal fade" id="modalParkir" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Parkir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="saveType">
                        <input type="hidden" id="dataId">
                        <div class="form-group">
                            <div class="row mt-1 update-type">
                                <div class="col-md-12">
                                    <label for="kodeUnik">Nomor Unik</label>
                                </div>
                                <div class="col-md-12">
                                    <h6 id="kodeUnik"></h6>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-12">
                                    <label for="nomorPolisi">Nomor Polisi</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" required class="form-control" id="nomorPolisi">
                                </div>
                            </div>
                            <div class="row mt-1 update-type">
                                <div class="col-md-12">
                                    <label for="nomorPolisi">Biaya Parkir</label>
                                </div>
                                <div class="col-md-12">
                                    <h6 id="biayaParkir"></h6>
                                    <input type="hidden" id="biayaParkirValue">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="save" type="button" class="btn btn-primary insert-type">Save</button>
                        <button id="keluar" type="button" class="btn btn-success update-type">Keluar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('script')
    <script src="{{ asset('js/parkir.js') }}"></script>
</body>

</html>