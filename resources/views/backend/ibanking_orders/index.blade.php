@extends('master.backend')

@section('content')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1><span class="text-danger" style="border-bottom: 1px dotted red;">iBanking Orders</span></h1>

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

                                        <th>SL</th>
                                      
                                        <th>Bank Name</th>
                                        <th>Account Number</th>
                                        <th>Amount (MVR)</th>
                                        <th>Amount (BDT)</th>
                                        <th>Screenshot Upload</th>
                                        <th>Status</th>
                                        <th>Ordered At</th>
                                        <th>Action</th>
                                    



                                    </tr>
                                </thead>
                                <tbody>

                                  
                                    @foreach($packageOrders as $key => $order)
                                    <tr>

                                        <td>{{ $key + 1 }}</td>

                                       @php
                          $bankID = $order->bank_name_id;
                          $bankName = DB::table('bank_names')->where('id', $bankID)->first();
                    @endphp
                                       
                                        <td>{{ $bankName->bank_name }}</td>

                                        <td>{{ $order->account_no }}</td>
                                        <td>{{ $order->amount }}</td>
                                        <td>{{ $order->bdt_amount ?? 0 }}</td>

                                        <td>

                                        @if($order->upload_slip)
    <!-- Button to Open Modal -->
    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#screenshotModal{{ $order->id }}">
        View
    </button>

    <!-- Modal -->
    <div class="modal fade" id="screenshotModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="screenshotModalLabel{{ $order->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="screenshotModalLabel{{ $order->id }}">iBanking Screenshot</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <img src="{{ asset('storage/' . $order->upload_slip) }}" class="img-fluid rounded" alt="Screenshot">
          </div>
        </div>
      </div>
    </div>
@else
    <span class="text-muted">No Image</span>
@endif

                                            <button type="button"
        class="btn btn-primary btn-sm"
        data-toggle="modal"
        data-target="#slipModal"
        data-id="{{ $order->id }}"
        data-note="{{ $order->upload_slip }}">
    <i class="fas fa-edit"></i> Upload Slip
</button>

<div class="modal fade" id="slipModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="slipForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Upload Slip (Screenshot)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="order_id">

                    <div class="form-group">
                        <label>Upload Slip</label>
                    <input type="file" class="form-control" name="upload_slip">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Update
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
                                        </td>
                                     
                                        <td>
                                            @if($order->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($order->status == 'approved')
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                                                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>

                                     

                                   <td>
                                            @if($order->status == 'pending')
                                                <a href="{{ route('admin.ibanking_orders.approve', $order->id) }}" class="btn btn-success btn-sm">Approve</a>
                                                <a href="{{ route('admin.ibanking_orders.reject', $order->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                            @elseif($order->status == 'approved')
                                                <a href="{{ route('admin.ibanking_orders.reject', $order->id) }}" class="btn btn-danger btn-sm">Reject</a>
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
    $(document).on("click", ".delete-btn", function (e) {
        e.preventDefault();

        let form = $(this).closest("form");

        swal({
            title: "Are you sure?",
            text: "Once deleted, this data cannot be recovered!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit(); // ✅ CORRECT
            } else {
                swal("Your data is safe!");
            }
        });
    });
</script>

<script>
    $('#noteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var orderId = button.data('id');
        var note = button.data('note');

        var modal = $(this);

        modal.find('#note_admin').val(note);

        var actionUrl = "{{ route('admin.mobile_banking_orders.update_note', ':id') }}";
        actionUrl = actionUrl.replace(':id', orderId);

        $('#noteForm').attr('action', actionUrl);
    });
</script>


<script>
    $('#slipModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var orderId = button.data('id');

        var actionUrl = "{{ route('admin.ibanking_orders.upload_slip', ':id') }}";
        actionUrl = actionUrl.replace(':id', orderId);

        $('#slipForm').attr('action', actionUrl);
    });
</script>



@endsection