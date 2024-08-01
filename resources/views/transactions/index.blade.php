@extends('layouts.main')
@section('main-section')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @if (Session::has('success'))
                <script>
                    swal("success", "{{ Session::get('success') }}", "success", {
                        button: true,
                        button: "OK",
                        //timer: 3000,
                        dangerMode: true,
                    });
                </script>
            @elseif (Session::has('delete'))
                <script>
                    swal("success", "{{ Session::get('delete') }}", "success", {
                        button: true,
                        button: "OK",
                        //timer: 3000,
                        dangerMode: true,
                    });
                </script>
            @elseif(Session::has('error'))
                <script>
                    swal("error", "{{ Session::get('error') }}", "info", {
                        button: true,
                        button: "OK",
                        //timer: 3000,
                        dangerMode: true,
                    });
                </script>
            @endif


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-sm-6 section-1" style="float: left !important;">
                                        <h2 class="card-title">{{ $heading }}</h2>
                                    </div>
                                    <div class="col-sm-6 section-2"
                                        style="float: left !important; text-align: right !important;">
                                        <button type="button" class="btn bg-primary"><a
                                                href="{{ route('transactions.create') }}">Add
                                                {{ $heading }}</a></button>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>Serial No</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $serial = 1; // Initialize serial number counter
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                        <tr class="text-center">
                                            <td>{{ $serial++ }}</td> <!-- Increment the serial number for each row -->
                                            <td>{{ $transaction->description }}</td>
                                            <td>{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->date }}</td>
                                            <td>
                                                @if ($transaction->type == 0)
                                                    Income
                                                @else
                                                    Expense
                                                @endif
                                            </td>
                                            <td class="project-actions">
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('transactions.edit', ['id' => $transaction->id]) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>

                                                {{-- <i class="fa-solid fa-eye-slash"></i> --}}
                                                <a class="btn btn-danger btn-sm"
                                                    href="{{ route('transactions.disable', ['id' => $transaction->id]) }}"
                                                    onclick="Disableconfirmation(event)">
                                                    <i class="fas fa-eye-slash"></i>
                                                    Disable
                                                </a>


                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection()
