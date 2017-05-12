            <section id="contacts-panel" class="panel">
                <ul>
                    <li id="self-contact">
                        <a href="{{ route('user.show', ['id' => Auth::user()->id]) }}" class="ajax-link user-show">
                            @include('user.avatar', ['size' => 64, 'user' => Auth::user()])
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    </li>
                    <ul class="nav contacts-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#contacts" aria-controls="contacts" role="tab" data-toggle="tab">Contacts</a></li>
                        <li role="presentation"><a href="#unread" aria-controls="unread" role="tab" data-toggle="tab" class="ajax-link unread-link" style="position: relative;">Unread
                        @if(Auth::user()->unreadCount() > 0)
                        <span class="unread" style="color: white; top: 20%;">{{ Auth::user()->unreadCount() }}</span>
                        @else
                        <span class="unread" style="color: white; top: 20%; display: none;">{{ Auth::user()->unreadCount() }}</span>
                        @endif
                        </a></li>
                    </ul>
                </ul>
                <div class="tab-content">
                    <ul id="contacts" class="tab-pane fade in active">    
                        @foreach(Auth::user()->contacts as $contact)
                           @include('layouts.contact')
                        @endforeach
                    </ul>
                    <ul id="unread" class="tab-pane fade">
                    </ul>
                </div>
            </section>