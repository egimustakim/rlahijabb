@extends('template.back')

@section('styles')
<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="page-title">
            <div class="title_left">
                <h3>Categories Page</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

      <!-- error message-->
      <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
          @if(Session::has('alert-' . $msg))

          <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
          @endif
        @endforeach
      </div> <!-- end .flash-message -->

          <!-- Modal Add Category-->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('categories.store')}}" method="POST" class="form-horizontal form-label-left">
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">New Categories</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" name="inputName" placeholder="Categories Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent Categories</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control" name="parentCat" id="">
                                        <option value="">---- SELECT PARENT ----</option>
                                        @foreach ($categories as $cat)
                                        <option value="{{ $cat['id'] }}">{{ $cat['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                        </form>
                </div>
                </div>
            </div>
            <!-- Modal Add Category-->

            <!-- Modal Edit Category-->
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Color</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('categories.update', 'update') }}" method="post" class="form-horizontal form-label-right">
                        {{ method_field('patch')}}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Material Name</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="hidden" class="form-control" name="categoryId" id="cat_id">
                                <input type="text" class="form-control" name="categoryName" id="cat_name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- Modal Edit Category-->

          <!-- Modal Delete Category-->
          <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Delete Color</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form action="{{ route('categories.destroy', 'delete') }}" method="post" class="form-horizontal form-label-right">
                          {{ method_field('delete')}}
                          {{ csrf_field() }}
                          <div class="form-group">
                              <p>Are you sure want to delete this data?</p>
                              <input type="hidden" class="form-control" name="categoryId" id="cate_id">
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-danger">Delete</button>
                      </div>
                          </form>
                  </div>
              </div>
          </div>
          <!-- Modal Delete Category-->

          <div class="clearfix"></div>

        <!-- Tabel Category-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">Add Categories</button>
                <div class="x_title">
                  <h2>Data Table <small>Categories</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <table id="" class="display table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1 ?>
                    @foreach ($categories as $cat)
                      <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $cat['name'] }}</td>
                        <td>
                        @foreach ($categories->where('id',$cat['parent_id']) as $item)
                        {{ $item['name'] }}
                        @endforeach
                        </td>
                        <td class="text-center"><button type="button" class="btn btn-info btn-sm" data-catname="{{ $cat['name'] }}" data-catid="{{ $cat['id'] }}" data-toggle="modal" data-target="#modalEdit">Edit</button></td>
                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm" data-catid="{{ $cat['id'] }}" data-toggle="modal" data-target="#modalDelete">Delete</button></td>
                      </tr>
                    <?php $no++ ?>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('table.display').DataTable();
} );
</script>

<script>
$('#modalEdit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var cat_name = button.data('catname') // Extract info from data-* attributes
    var cat_id = button.data('catid')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body #cat_name').val(cat_name)
    modal.find('.modal-body #cat_id').val(cat_id)
})

$('#modalDelete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var cate_id = button.data('catid') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body #cate_id').val(cate_id)
})
</script>

@endsection
