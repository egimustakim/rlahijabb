@extends('template.back')

@section('styles')
<!-- Datatables -->
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Colors Page</h3>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Add New Color</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('colors.store')}}" method="POST" class="form-horizontal form-label-right">
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input class="form-control" type="text" name="colorName" placeholder="Fill color name here ...">
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

        <!-- Modal Edit Material-->
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
                        <form action="{{ route('colors.update', 'update') }}" method="post" class="form-horizontal form-label-right">
                        {{ method_field('patch')}}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Material Name</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="hidden" class="form-control" name="materialId" id="mat_id">
                                <input type="text" class="form-control" name="materialName" id="mat_name">
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
        <!-- Modal Edit Material-->

          <!-- Modal Delete Material-->
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
                          <form action="{{ route('colors.destroy', 'delete') }}" method="post" class="form-horizontal form-label-right">
                          {{ method_field('delete')}}
                          {{ csrf_field() }}
                          <div class="form-group">
                              <p>Are you sure want to delete this data?</p>
                              <input type="hidden" class="form-control" name="materialId" id="mate_id">
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
          <!-- Modal Delete Material-->

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Add New Color</button>
            <div class="x_title">
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
                  <table id="datatableProvinces" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Color</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Preview</th>
                        <th colspan="2" class="text-center">Action</th>
                      </tr>
                      <tr>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        @foreach ($colors as $color)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $color['name']}}</td>
                            <td></td>
                            <td class="text-center"><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEdit" data-colname="{{ $color['name']}}" data-colid="{{ $color['id']}}">Edit</button></td>
                            <td class="text-center"><button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete" data-colid="{{ $color['id']}}">Delete</button></td>
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
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection

@section('scripts')
    <!-- Datatables -->
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatableProvinces').DataTable();
        });
    </script>
@endsection
