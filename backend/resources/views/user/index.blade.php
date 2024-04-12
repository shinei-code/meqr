@section('title', 'Title')
<x-app>
    <!-- メインコンテンツ -->
    <main class="w-100 mx-3">
    <div class="container-fluid">
        <h3 class="page-title">ユーザ</h3>
        <!-- 検索フォーム -->
        <div class="card search-card">
            <div class="card-body">
                <div class="row mb-4">
                    <!-- 職員番号 -->
                    <div class="col-6 mb-2">
                        <label for="staff-number" class="form-label label-sm">職員番号</label>
                        <input type="text" class="form-control" id="staff-number" aria-describedby="staff-number">
                    </div>
                </div>
                <!-- 検索ボタン -->
                <div class="row mt-3 d-flex justify-content-center">
                    <div class="btn-width">
                        <button type="button" class="btn search-btn me-2 w-100"><i class="fas fa-search"></i>&ensp;検索</button>
                    </div>
                    <div class="btn-width icon-position">
                        <input type="reset" value="&ensp;&ensp;入力クリア" class="btn btn-outline-secondary clear-btn w-100">
                        <i class="far fa-trash-alt reset-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        @include('components.session')

        @if($users->total() > 0)
            <p class="csss-description">検索結果{{$users->total()}}件のうち、{{ $users->firstItem() }}件目から{{$users->lastItem()}}
                件目までを表示しています。</p>
        @endif
        <div class="d-flex justify-content-end mt-5">
        {{ $users->links() }}
        <!-- 医療機関一覧テーブル -->
        <table class="table table-bordered table-hover mb-5 align-middle">
            <thead>
            <tr class="hospitals-table text-center align-middle">
                <th scope="col" class="col-1">ユーザーID</th>
                <th scope="col" class="col-2">氏名</th>
                <th scope="col" class="col-1">権限</th>
                <th scope="col" class="col-1"></th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var \App\Models\User $user */ ?>
            @foreach($users as $user)
                <tr class="pointer static-clicker">
                    <td class=""><a href="javascript:void(0)">{{ $user->staff_no }}</a></td>
                    <td class="">{{ $user->name }}</td>
                    <td class="">{{ $user->role }}</td>
                    <td class="text-center">
                        <a class="btn btn-primary btn-sm" href="{{ route('user.edit', $user) }}"><i class="far fa-edit"></i> 編集</a> <a
                            onclick="return confirm(&quot;利用者：{{ $user->name }}さんを削除してもよろしいですか。&quot;);"
                            class="btn btn-danger btn-sm"
                            href="{{ route('user.delete', $user) }}"><i class="far fa-trash-alt"></i>
                            削除</a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </main>
</x-app>
