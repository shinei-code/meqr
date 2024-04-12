@section('title', 'Title')
<x-app>
    <h3 class="page-title">保険者</h3>
    <!-- 検索フォーム -->
    {!! Form::open(['url' => route('insurance.index'),'method' => 'get','id' => 'searchForm']) !!}
        <div class="card search-card">
            <div class="card-body">
                <div class="row">
                    <!-- 保険者番号 -->
                    <div class="col-6">
                        <label for="search-hokenja-code" class="form-label label-sm">保険者番号</label>
                        {!! Form::text('search[code]', request()->input('search.code'),['class' => 'form-control','id' => 'search-hokenja-code']) !!}
                    </div>
                    <!-- 保険者名 -->
                    <div class="col-6">
                        <label for="search-hokenja-name" class="form-label label-sm">保険者名</label>
                        {!! Form::text('search[name]', request()->input('search.name'),['class' => 'form-control','id' => 'search-hokenja-name']) !!}
                    </div>
                </div>
                <!-- 保険者区分 -->
                <div class="label-sm mb-2 mt-3">保険者区分</div>
                <div class="row gx-0">
                    @foreach(code('hoken_kind_kbn')->pluck('value','key') as $key => $name)
                        <div class="col-1 mb-3 form-check form-check-inline">
                            <label class="form-check-label">
                            {!! Form::checkbox('search[type][]', $key, in_array($key, request()->has('search.type') ? request()->input('search.type') : []), ['class' => 'form-check-input']) !!}
                            {{ $name }}</label>
                        </div>
                    @endforeach
                </div>
                <!-- 検索ボタン -->
                <div class="row mt-3 d-flex justify-content-center">
                    <div class="btn-width">
                        <button type="submit" class="btn search-btn me-2 w-100"><i class="fas fa-search"></i>&ensp;検索</button>
                    </div>
                    <div class="btn-width icon-position">
                        <input type="reset" value="&ensp;&ensp;入力クリア" class="btn btn-outline-secondary clear-btn w-100">
                        <i class="far fa-trash-alt reset-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="d-flex justify-content-between mt-5">
        <!-- CSVダウンロード -->
        <a href="{{ route('insurance.csv',request()->query()) }}" target="_blunk">
            <button type="button" class="btn btn-outline-secondary mb-3 px-3 download-btn csvConfirmDownloadBtn" data-url="">
                <i class="fas fa-file-download me-1"></i>
                CSVダウンロード
            </button>
        </a>
    @include('components.session')
    {{ $insurances->links() }}
    </div>
    <!-- 保険者一覧テーブル -->
    <table class="table table-bordered table-hover mb-5 align-middle">
        <thead>
        <tr class="insurances-table text-center align-middle">
            <th scope="col" class="col-2">保険者番号</th>
            <th scope="col" class="col-3">保険者名</th>
            <th scope="col" class="col-1">種別</th>
            <th scope="col" class="col-1">非表示</th>
            <th scope="col" class="col-1"></th>
        </tr>
        </thead>
        <tbody>
        <?php /** @var \App\Models\Insurance $insurance */ ?>
        @foreach($insurances as $insurance)
            <tr class="pointer static-clicker">
                <td class="">{{ $insurance->code }}</td>
                <td class="">{{ $insurance->name }}</td>
                <td class="">{{ $insurance->hoken_kind->value }}</td>
                <td class="">@if($insurance->is_not_display)<i class="fas fa-check"></i>@endif</td>
                <td class="text-center">
                    <a class="btn btn-outline-success change-btn" href="{{ route('insurance.edit', $insurance) }}"><i class="far fa-edit"></i> 変更</a> <a
                        onclick="return confirm(&quot;保険者：{{ $insurance->name }}を削除してもよろしいですか。&quot;);"
                        class="btn btn-outline-danger delete-btn"
                        href="{{ route('insurance.delete', $insurance) }}"><i class="far fa-trash-alt"></i>
                        削除</a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app>
