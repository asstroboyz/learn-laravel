<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Sticky Wall' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #f6fbff; margin:0; }
        .sticky-container { display: flex; min-height: 100vh; }
        .sidebar {
            background: #f9fbfc; width: 250px; padding: 2.1rem 1.6rem 2rem 1.6rem;
            border-right: 2px solid #e8eefa; min-height:100vh;
        }
        .sidebar h2 { font-size:1.25rem; font-weight:700; margin-bottom:2rem; color:#263249;}
        .sidebar ul { padding: 0; margin: 0; list-style:none;}
        .sidebar li {
            margin-bottom: 1rem; color: #3546b0;
            font-size: 1.09rem; font-weight: 600;
            cursor:pointer; padding: 0.6rem 1rem; border-radius:0.8rem;
            background: #fff; transition:.13s; border: 2px solid #f4f7ff;
        }
        .sidebar li.selected, .sidebar li:hover { background: #e3eafd; border-color:#b3d2f7; color:#182168; }
        .sidebar a { text-decoration:none;color:inherit;display:block; }
        .main-area { flex:1; padding: 2.3rem 2.4rem 1.2rem 2.4rem;}
        .wall-title { font-size:2rem; font-weight:700; margin-bottom:2.1rem; color:#263249;}
        .sticky-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem 1.8rem; }
        .sticky-card {
            min-height: 150px; border-radius: 1.1rem;
            box-shadow: 0 2px 14px 0 rgba(41,71,255,0.06);
            padding: 1.1rem 1.1rem 0.7rem 1.2rem;
            background: #fff; border: 2.5px solid #f6fbff;
            font-family: 'Inter', Arial, sans-serif;
            transition: box-shadow .13s, transform .12s; position:relative;
        }
        .sticky-yellow { background: #fffbe6; border-color: #fff1ab; }
        .sticky-blue   { background: #e9f6ff; border-color: #b5e4fd; }
        .sticky-pink   { background: #fff2f5; border-color: #ffb3c8; }
        .sticky-orange { background: #fff7e6; border-color: #ffd4a1; }
        .sticky-green  { background: #e6ffef; border-color: #a9f1c7; }
        .sticky-card h4 { margin:0 0 0.5rem 0; font-size:1.09rem; font-weight:700; }
        .sticky-card ul { margin:0.45rem 0 0 1rem; padding:0; font-size:1rem;}
        .sticky-card .remove-btn {
            position: absolute; top: 13px; right: 13px;
            background: none; border: none; color: #ce223a; font-size: 1.15rem; cursor: pointer;
        }
        .add-btn {
            position:fixed; top:38px; right:38px; z-index:3;
            background:linear-gradient(90deg,#3546b0 0%,#5c81e7 100%);
            color:#fff; border:none; border-radius:12px;
            padding:0.81rem 1.7rem; font-weight:700; font-size:1.08rem;
            letter-spacing:0.2px; cursor:pointer; box-shadow:0 2px 10px 0 rgba(41,71,255,0.08);
        }
        .add-modal-bg {
            display: none; position: fixed; top:0; left:0; right:0; bottom:0;
            background:rgba(38,49,71,0.08); z-index:100; align-items:flex-start; justify-content:flex-end;
        }
        .add-modal {
            background: #fff; border-radius: 1.1rem; min-width:320px; margin: 56px 44px 0 0; box-shadow:0 8px 40px 0 rgba(41,71,255,0.13);
            padding:1.7rem 1.3rem 1.1rem 1.4rem; position:relative; animation:fadeInUp .3s;
        }
        .add-modal h3 { font-size:1.16rem; font-weight:700; margin-bottom:1.1rem;}
        .add-modal input, .add-modal select { width:100%; padding:0.67rem 0.85rem; border-radius:9px; border:1.2px solid #e3e8f1; margin-bottom:0.8rem; font-size:1.04rem;}
        .add-modal button[type="submit"] {
            background:linear-gradient(90deg,#3546b0 0%,#5c81e7 100%); color:#fff; border:none; border-radius:9px; padding:0.72rem 1.2rem; font-size:1.02rem; font-weight:700; cursor:pointer;
        }
        .add-modal .close-add-form { position: absolute; top: 1rem; right: 1rem; background:none; border:none; color:#b6b6b6; font-size:1.3rem; cursor:pointer;}
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px);} to { opacity:1; transform: none;} }
        @media (max-width: 900px) { .sticky-container { flex-direction:column;} .sidebar{ width:100%; border-right:none; border-bottom:2px solid #e8eefa; } .main-area {padding:1.3rem;} .add-btn{top:18px;right:18px;}}
    </style>
</head>
<body>
<div class="sticky-container">
    <!-- Sidebar Kategori -->
    <div class="sidebar">
        <h2>☑️ Kategori</h2>
        <ul>
            <li class="{{ empty($selectedCategory) ? 'selected' : '' }}">
                <a href="{{ url('/todolist') }}">Semua</a>
            </li>
            @foreach($grouped as $category => $list)
                <li class="{{ ($selectedCategory ?? '') === $category ? 'selected' : '' }}">
                    <a href="{{ url('/todolist') . '?category=' . urlencode($category) }}">
                        {{ $category }}
                        <span style="float:right;color:#b4b8c9;font-size:0.99rem;">{{ count($list) }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- Main Sticky Wall -->
    <div class="main-area">
        <div class="wall-title">Sticky Wall</div>
        <div class="sticky-grid">
            @php
                $categoryColors = [
                    'Social Media' => 'sticky-yellow', 'Content Strategy' => 'sticky-blue',
                    'Email A/B Tests' => 'sticky-pink', 'Banner Ads' => 'sticky-orange',
                    'Personal' => 'sticky-green', 'Bug' => 'sticky-pink', 'Feature' => 'sticky-yellow',
                    'Review' => 'sticky-blue', 'Deploy' => 'sticky-orange',
                    // Add more category => color here if needed
                ];
            @endphp
            @if(isset($todos) && count($todos) > 0)
                @foreach($todos as $category => $list)
                    @if(is_array($list))
                    <div class="sticky-card {{ $categoryColors[$category] ?? 'sticky-blue' }}">
                        <h4>{{ $category }}</h4>
                        <ul>
                            @forelse($list as $todo)
                                <li style="margin-bottom:0.55rem;display:flex;align-items:center;justify-content:space-between;">
                                    <span>{{ $todo['todo'] ?? '-' }}</span>
                                    <form action="/todolist/{{ $todo['id'] ?? '' }}/delete" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="remove-btn" title="Remove" onclick="return confirm('Yakin hapus todo ini?')">×</button>
                                    </form>
                                </li>
                            @empty
                                <li style="color:#bbb;padding:1.2rem 0;font-style:italic;">Belum ada todo</li>
                            @endforelse
                        </ul>
                    </div>
                    @endif
                @endforeach
            @else
                <div style="grid-column:1/-1;text-align:center;color:#bbc0d1;font-size:1.25rem;padding:2.4rem;">
                    <div style="font-size:3.2rem;line-height:1.1;">🪧</div>
                    Tidak ada todo untuk kategori ini!
                </div>
            @endif
        </div>
    </div>
    <!-- Tombol Tambah (Fixed Atas Kanan) -->
    <button class="add-btn" id="showAddFormBtn">+ Tambah Todo</button>
    <!-- Modal Add Todo -->
    <div class="add-modal-bg" id="addFormPopup">
        <div class="add-modal">
            <button class="close-add-form" id="closeAddFormBtn">&times;</button>
            <h3>Tambah Todo</h3>
            <form method="POST" action="/todolist">
                @csrf
                <input type="text" name="todo" placeholder="Isi todo..." required autofocus>
                <!-- Kategori baru atau pilih -->
                <select name="category" id="categorySelect" required onchange="toggleCustomCategory()">
                    <option value="">Pilih kategori</option>
                    @foreach($allCategories as $cat)
                        <option value="{{ $cat }}" {{ ($selectedCategory ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                    <option value="__custom__">+ Kategori Baru...</option>
                </select>
                <input type="text" name="custom_category" id="customCategoryInput" placeholder="Kategori baru..." style="display:none;margin-bottom:0.7rem;">
                <button type="submit">Tambah</button>
            </form>
        </div>
    </div>
</div>
<script>
    // Modal logic
    document.getElementById('showAddFormBtn').onclick = function(){
        document.getElementById('addFormPopup').style.display = 'flex';
    };
    document.getElementById('closeAddFormBtn').onclick = function(){
        document.getElementById('addFormPopup').style.display = 'none';
    };
    document.querySelector('.add-modal form').onsubmit = function(){
        setTimeout(()=>document.getElementById('addFormPopup').style.display = 'none', 250);
    };

    // Show/hide custom category
    function toggleCustomCategory() {
        var sel = document.getElementById('categorySelect');
        var inp = document.getElementById('customCategoryInput');
        inp.style.display = sel.value === '__custom__' ? 'block' : 'none';
        inp.required = sel.value === '__custom__';
    }
</script>
</body>
</html>
