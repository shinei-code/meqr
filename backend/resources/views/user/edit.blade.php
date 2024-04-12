@section('title', 'Title')
<x-app>
    <!-- メインコンテンツ -->
    <main class="w-100 mx-3">
        <div class="container-fluid mb-5">
            <h3 class="page-title">ユーザー登録</h3>

            <div class="ms-2">
            @include('components.session')
            @include('components.form-error')
            @if(empty($user->id))
                {!! Form::model($user, ['route' => ['user.store'], 'class' => '', 'accept-charset' => 'utf-8']) !!}
            @else
                {!! Form::model($user, ['route' => ['user.update', $user], 'class' => '', 'accept-charset' => 'utf-8','method' => 'put']) !!}
            @endif

                <!-- ユーザーID -->
                <div class="mb-4">
                    <label for="user-id" class="form-label label-sm">
                        ユーザーID<span class="required">必須</span>
                    </label>
                    {!! Form::text('staff_no', old('staff_no'), ['required' => 'required', 'class' => 'form-control w-50']) !!}
                </div>
                <!-- 氏名 -->
                <div class="mb-4">
                    <label for="name" class="form-label label-sm">
                        氏名<span class="required">必須</span>
                    </label>
                    {!! Form::text('name', old('name'), ['required' => 'required','class' => 'form-control  w-50']) !!}
                    <p class="help-block"></p>

                </div>
                <!-- パスワード -->
                <div class="mb-4">
                    <label for="password" class="form-label label-sm">
                        パスワード<span class="required">必須</span>
                    </label>
                    @if(empty($user->id))
                        {!! Form::password('password', ['required' => 'required','class' => 'form-control  w-50']) !!}
                    @else
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    @endif
                    <p class="help-block"></p>
                </div>
                <!-- 権限 -->
                <div class="mb-4">
                    <div class="label-sm mb-2">権限<span class="required">必須</span></div>
                    @foreach(code('role')->pluck('value','key') as $key => $name)
                        <div class="form-check ms-3">
                            <label class="form-check-label">
                                {!! Form::radio('role', $key, old('role', $user->role) == $key, ['class' => 'form-check-input']) !!}
                                {{ $name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- 画面遷移ボタン -->
        <div class="row mt-3 mb-5 ms-2 d-flex justify-content-center">
            <div class="col-3">
                <button type="submit" class="btn search-btn me-2 w-100">登録</button>
            </div>
            <div class="col-2">
                <a class="btn btn-default" href="{{ route('user.index') }}">
                <button type="button" class="btn btn-outline-secondary clear-btn w-100">キャンセル</button>
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    </main>
</x-app>
