<div>
    <style>
        img {
            border-radius: 50%;
            display: inline;
            width: 44px;
            height: 44px;
            margin-right: 10px;
        }
    </style>
    @foreach ($users as $user)
        <ul class="w-75 mx-auto mt-3 container-fluid list-group">

            <li class="list-group-item list-group-item-action" wire:click="checkConversation({{ $user->id }})">
                <img src="https://ui-avatars.com/api/?background=random&color=fff&name={{ $user->name }}"
                    alt="">
                {{ $user->name }}
            </li>
        </ul>
    @endforeach
</div>
