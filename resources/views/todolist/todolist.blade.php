<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Todolist' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(120deg, #f0f4f8 0%, #e2eafc 100%);
            min-height: 100vh;
        }

        .todolist-card {
            box-shadow: 0 6px 32px 0 rgba(41, 71, 255, 0.09), 0 1.5px 8px 0 rgba(41, 71, 255, 0.02);
            border-radius: 1.25rem;
            border: none;
        }

        .todo-title {
            letter-spacing: -0.01em;
            font-weight: 700;
            color: #273043;
        }

        .btn-primary {
            background: linear-gradient(90deg, #3546b0 0%, #5c81e7 100%);
            border: none;
        }

        .btn-danger {
            border-radius: 12px;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #f3f7fa;
        }

        .footer-credits {
            color: #aaa;
            font-size: 0.9rem;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <div class="container col-xl-10 col-xxl-8 px-4 py-5">

        @if (isset($error))
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            </div>
        @endif

        <div class="row mb-3">
            <form method="post" action="/logout" class="text-end">
                @csrf
                <button class="btn btn-danger" type="submit">Sign Out</button>
            </form>
        </div>

        <div class="row align-items-center g-lg-5 py-3">
            <div class="col-lg-7 text-center text-lg-start">
                <h1 class="display-4 fw-bold lh-1 mb-3 todo-title">
                    <span>📝</span> Todolist
                </h1>
                <p class="col-lg-10 fs-5 mb-1">
                    Made with ☕ by
                    <a target="_blank" class="text-decoration-none" style="color:#3546b0;font-weight:600;"
                        href="https://asstroboyz.github.io/">
                        Kiding Todo List
                    </a>
                </p>
            </div>
            <div class="col-md-10 mx-auto col-lg-5">
                <form class="p-4 p-md-5 border rounded-3 bg-light todolist-card" method="post" action="/todolist">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="todo" id="todo" placeholder="todo"
                            autocomplete="off">
                        <label for="todo">Todo</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Add Todo</button>
                </form>
            </div>
        </div>

        <div class="row align-items-right g-lg-5 py-3">
            <div class="mx-auto">
                <form id="deleteForm" method="post" style="display: none"></form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Todo</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($todolist) == 0)
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <span style="font-size:2rem;">😴</span>
                                    <div class="mt-2">Belum ada todo, yuk tambah satu!</div>
                                </td>
                            </tr>
                        @else
                            @foreach ($todolist as $todo)
                                <tr>
                                    <th scope="row">{{ $todo['id'] }}</th>
                                    <td>{{ $todo['todo'] }}</td>
                                    <td>
                                        <form action="/todolist/{{ $todo['id'] }}/delete" method="post"
                                            onsubmit="return confirm('Yakin mau hapus todo ini?')">
                                            @csrf
                                            <button class="btn btn-danger btn-sm" type="submit">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer-credits text-center">
            &copy; {{ date('Y') }} <span style="color:#3546b0;font-weight:600;">Kiding Todo List</span> — Made with
            ❤️ in asstroboyz Lab
        </div>
    </div>
</body>

</html>
