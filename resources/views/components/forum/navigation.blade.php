<div id="bbp-user-navigation" class="bbp-user-navigation-hide">

    <ul class="list-group">

        <li class="list-group-item bg-primary">
            <span class="bbp-user-profile-link">
                <a class="text-white" href="{{ route('forums.users') . '/' . $user->pseudo }}"
                    title="{{ $user->pseudo }} Profile" rel="me">Profile</a>
            </span>
        </li>

        <li class="list-group-item @if (Route::current()->getName() == 'forums.users.topics') active @endif">
            <span class="bbp-user-topics-created-link">
                <a href="{{ route('forums.users.topics') . '/' . $user->pseudo }}"
                    title="{{ $user->pseudo }} Sujets commencés">Sujets commencés</a>
            </span>

        </li>

        <li class="list-group-item @if (Route::current()->getName() == 'forums.users.replies') active @endif">
            <span class="bbp-user-replies-created-link">
                <a href="{{ route('forums.users.replies') . '/' . $user->pseudo }}"
                    title="{{ $user->pseudo }} Replies Created">Réponses créées</a>
            </span>
        </li>

        <li class="list-group-item @if (Route::current()->getName() == 'forums.users.favorites') active @endif">
            <span class="bbp-user-favorites-link">
                <a href="{{ route('forums.users.favorites') . '/' . $user->pseudo }}"
                    title="{{ $user->pseudo }} Favorites">Favoris</a>
            </span>
        </li>

    </ul>

</div>
