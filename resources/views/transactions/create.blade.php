@extends('layouts.main')
@section('main-section')
    <section class="content">
        <div class="container-fluid">
            <!-- Alert Messages -->
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
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $heading }}</h3>
                        </div>
                        <form action="{{ $actionurl }}" method="post">
                            @csrf
                            <!-- If $Court exists, include its ID -->
                            @isset($transaction)
                                <input type="hidden" name="id" value="{{ $transaction->id }}">
                            @endisset
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" placeholder="Enter Description"
                                           name="description" value="{{ isset($transaction) ? $transaction->description : old('description') }}">
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" placeholder="Enter Amount"
                                           name="amount" value="{{ isset($transaction) ? $transaction->amount : old('amount') }}">
                                    @error('amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control"
                                           name="date" value="{{ isset($transaction) ? $transaction->date : old('date') }}">
                                    @error('date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type">
                                        <option value="0" {{ (isset($transaction) && $transaction->type == '0') ? 'selected' : '' }}>Income</option>
                                        <option value="1" {{ (isset($transaction) && $transaction->type == '1') ? 'selected' : '' }}>Expense</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $btntext }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
