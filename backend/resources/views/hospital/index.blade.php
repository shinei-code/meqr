@section('title', 'Title')
<x-app>
            <h3 class="page-title">医療機関</h3>
            <!-- 検索フォーム -->
    {!! Form::open(['url' => route('hospital.index'),'method' => 'get','id' => 'searchForm']) !!}
                <div class="card search-card">
                    <div class="card-body">
                        <div class="row">
                            <!-- 医療機関コード -->
                            <div class="col-6">
                                <label for="search-hospitals-code" class="form-label label-sm">医療機関コード</label>
                                {!! Form::text('search[code]', request()->input('search.code'),['class' => 'form-control','id' => 'search-hospitals-code']) !!}
                            </div>
                            <!-- 医療機関名 -->
                            <div class="col-6">
                                <label for="search-hospitals-name" class="form-label label-sm">医療機関名</label>
                                {!! Form::text('search[name]', request()->input('search.name'),['class' => 'form-control','id' => 'search-hospitals-name']) !!}
                            </div>
                        </div>
                        <!-- 医療機関区分 -->
                        <div class="label-sm mb-2 mt-3">医療機関区分</div>
                        <div class="row gx-0">
                            @foreach(code('hospital_type')->pluck('value','key') as $key => $name)
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
            @include('components.session')

    <div class="d-flex justify-content-between mt-5">
                <!-- CSVダウンロード -->
        <a href="{{ route('hospital.csv',request()->query()) }}" target="_blunk">
                <button type="button" class="btn btn-outline-secondary mb-3 px-3 download-btn">
                    <i class="fas fa-file-download me-1"></i>
                    CSVダウンロード
                </button>
        </a>
        @include('components.session')
        {{ $hospitals->links() }}
    </div>
    @if($hospitals->total() > 0)
        <p class="csss-description">検索結果{{$hospitals->total()}}件のうち、{{ $hospitals->firstItem() }}件目から{{$hospitals->lastItem()}}
            件目までを表示しています。</p>
@endif
    <!-- 医療機関一覧テーブル -->
        <table class="table table-bordered table-hover mb-5 align-middle">
            <thead>
            <tr class="hospitals-table text-center align-middle">
                <th scope="col" class="col-1">医療機関<br>コード</th>
                <th scope="col" class="col-3">医療機関名</th>
                <th scope="col" class="col-1">種別</th>
                <th scope="col" class="col-3">住所</th>
                <th scope="col" class="col-2">電話番号</th>
                <th scope="col" class="col-1">非表示</th>
                <th scope="col" class="col-1"></th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var \App\Models\User $hospital */ ?>
            @foreach($hospitals as $hospital)
                <tr class="pointer static-clicker">
                    <td class="">{{ $hospital->code }}</td>
                    <td class="">{{ $hospital->name }}</td>
                    <td class="">{{ $hospital->hospital_type->value }}</td>
                    <td class="">{{ $hospital->address }}</td>
                    <td class="">{{ $hospital->tel }}</td>
                    <td class="">@if($hospital->is_not_display)<i class="fas fa-check"></i>@endif</td>
                    <td class="text-center">
                        <a class="btn btn-outline-success change-btn" href="{{ route('hospital.edit', $hospital) }}"><i class="far fa-edit"></i> 編集</a> <a
                            onclick="return confirm(&quot;医療機関：{{ $hospital->name }}を削除してもよろしいですか。&quot;);"
                            class="btn btn-outline-danger delete-btn"
                            href="{{ route('hospital.delete', $hospital) }}"><i class="far fa-trash-alt"></i>
                            削除</a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

</x-app>
