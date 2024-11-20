@extends('layouts.app')

@section('template_title')
    Proyectos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Proyectos') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('proyectos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Create New') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <th>Nombre</th>
                                        <th>Imagen</th>
                                        <th>Descripcion</th>
                                        <th>Url</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proyectos as $proyecto)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $proyecto->nombre }}</td>

                                            <td>
                                                @if ($proyecto->imagen)
                                                    <a href="{{ asset('storage/' . $proyecto->imagen) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $proyecto->imagen) }}"
                                                            alt="Imagen del Proyecto"
                                                            style="max-width: 100px; max-height: 100px; object-fit: contain;" />
                                                    </a>
                                                @else
                                                    <span>No image</span>
                                                @endif
                                            </td>

                                            <td>{{ $proyecto->descripcion }}</td>
                                            <td>{{ $proyecto->url }}</td>

                                            <td>
                                                <form action="{{ route('proyectos.destroy', $proyecto->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('proyectos.show', $proyecto->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('proyectos.edit', $proyecto->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $proyectos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
