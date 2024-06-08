<form action="{{ $action }}" method="GET" class="m-0">
    <div class="input-group rounded">
        <span class="input-group-text bg-white border-light" id="search-addon"
            style="border-top-left-radius: 20px; border-bottom-left-radius: 20px">
            <i class="fas fa-search"></i>
        </span>
        <input type="search" name="search" class="form-control rounded-end-circle border-light" placeholder="Search..."
            aria-label="Search" aria-describedby="search-addon" value="{{ request('search') }}"
            style="border-top-right-radius: 20px; border-bottom-right-radius: 20px">
        {{-- <button type="submit" class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
            </button> --}}
    </div>
</form>
