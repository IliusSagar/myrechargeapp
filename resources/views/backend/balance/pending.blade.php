@extends('master.backend')

@section('content')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1><span class="text-danger" style="border-bottom: 1px dotted red;">List Balance</span></h1>

                </div>



            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- /.card -->

                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Sl</th>
                                        <th>User Name</th>
                                        <th>Account Number</th>
                                        <th>Amount</th>
                                        <th>Transaction ID</th>
                                        <th>Screenshot View</th>
                                        <th>Note</th>
                                        <th>Status</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($pendingTransactions as $key => $transaction)
                                    <tr>

                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                        <td>{{ $transaction->account->account_number ?? 'N/A' }}</td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->transaction_id }}</td>
                             <td>
@if($transaction->file_upload)
    <!-- Button to Open Modal -->
    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#screenshotModal{{ $transaction->id }}">
        View
    </button>

    <!-- Modal -->
    <div class="modal fade" id="screenshotModal{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="screenshotModalLabel{{ $transaction->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="screenshotModalLabel{{ $transaction->id }}">Transaction Screenshot</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <img src="{{ asset('storage/' . $transaction->file_upload) }}" class="img-fluid rounded" alt="Screenshot">
          </div>
        </div>
      </div>
    </div>
@else
    <span class="text-muted">No Image</span>
@endif
</td>

<td>
{{ $transaction->note ?? 'N/A' }}
</td>



                            

                                        <td class="badge bg-warning">{{ ucfirst($transaction->status) }}
                                            
                                        </td>

                                        <td>
                                           

            @if ($transaction->status === 'pending')
        <a href="{{ route('admin.balance.approved', $transaction->id) }}" class="btn btn-sm btn-success">Approve</a>
        <a href="{{ route('admin.balance.rejected', $transaction->id) }}" class="btn btn-sm btn-danger">Reject</a>
        @elseif ($transaction->status == 'approved')
        <a href="{{ route('admin.balance.rejected', $transaction->id) }}" class="btn btn-sm btn-danger">Reject</a>
    @else
        <span class="text-muted">No actions</span>
    @endif
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
    <!-- /.content -->
</div>

<script>
    $(document).on("click", "#delete", function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        swal({
                title: "Are you want to delete?",
                text: "Once Delete, This will be Permanently Delete!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = link;
                } else {
                    swal("Safe Data!");
                }
            });
    });
</script>




@endsection