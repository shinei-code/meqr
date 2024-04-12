@section('title', 'Title')
<x-app>
    <h3 class="page-title">コード</h3>
    <!-- 検索フォーム -->
        {!! Form::open(['url' => route('code.index'),'method' => 'get','id' => 'searchForm']) !!}
        <div class="card search-card">
            <div class="card-body">
                <div class="row mb-4">
                    <!-- カテゴリ -->
                    <div class="col-6 mb-2">
                        <label for="search-category" class="form-label label-sm">カテゴリ</label>
                        {!! Form::text('search[category]', request()->input('search.category'),['class' => 'form-control','id' => 'search-category']) !!}
                    </div>
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
        <a href="{{ route('code.csv',request()->query()) }}" target="_blunk">
                <button type="button" class="btn btn-outline-secondary mb-3 px-3 download-btn">
                    <i class="fas fa-file-download me-1"></i>
                    CSVダウンロード
                </button>
        </a>
        @include('components.session')
        {{ $codes->links() }}
    </div>
    @if($codes->total() > 0)
        <p class="csss-description">検索結果{{$codes->total()}}件のうち、{{ $codes->firstItem() }}件目から{{$codes->lastItem()}}
            件目までを表示しています。</p>
@endif
    <!-- 一覧テーブル -->
        <table class="table table-bordered table-hover mb-5 align-middle">
            <thead>
            <tr class="codes-table text-center align-middle">
                <th scope="col" class="col-2">カテゴリ</th>
                <th scope="col" class="col-1">キー</th>
                <th scope="col" class="col-1">値</th>
                <th scope="col" class="col-1">値２</th>
                <th scope="col" class="col-1">表示順</th>
                <th scope="col" class="col-1">非表示</th>
                <th scope="col" class="col-1"></th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var \App\Models\Code $code */ ?>
            @foreach($codes as $code)
                <tr class="pointer static-clicker">
                    <td class="">{{ $code->category }}</td>
                    <td class="">{{ $code->key }}</td>
                    <td class="">{{ $code->value }}</td>
                    <td class="">{{ $code->sub_value }}</td>
                    <td class="">{{ $code->display_order }}</td>
                    <td class="">@if($code->is_not_display)<i class="fas fa-check"></i>@endif</td>
                    <td class="text-center">
                        <a class="btn btn-outline-success change-btn" href="{{ route('code.edit', $code) }}"><i class="far fa-edit"></i> 編集</a> <a
                            onclick="return confirm(&quot;コード：{{ $code->value }}を削除してもよろしいですか。&quot;);"
                            class="btn btn-outline-danger delete-btn"
                            href="{{ route('code.delete', $code) }}"><i class="far fa-trash-alt"></i>
                            削除</a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

</x-app>
