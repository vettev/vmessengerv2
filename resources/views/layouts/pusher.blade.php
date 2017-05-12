<script src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script>
    //Pusher.logToConsole = true;

    let pusher = new Pusher('a1967b216298382ddcbf', {
    cluster: 'eu',
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
  });

    let channelName = "private-user-{{ Auth::user()->id }}";
    let channel = pusher.subscribe(channelName);
    channel.bind('message', function(data)
    {
        let conversation = $('#conversation-' + data['sender_id']);
        if(conversation.length === 1)
        {
            let messages = conversation.find('.messages');
            let message = newMessage(
                data['content'], data['sender'], data['created_at']
            );
            messages.append(message);
            messages.animate({scrollTop: messages[0].scrollHeight});
        }
        else
        {
            let contact = $('#contact-' + data['sender_id']);
            if(contact.length === 0)
            {
                let unreadCount = parseInt($('.unread-link .unread').html());
                unreadCount++;
                $('.unread-link .unread').html(unreadCount).show();
            }
            else
            {
                let unread = parseInt(contact.find('.unread').html());
                unread++;
                $('#contact-' + data['sender_id'])
                .find('.unread').show().html(unread);
            }
        }
    });

    function newMessage(content, sender, createdAt)
    {
        let messageTemplate = $('#message-template');
        let message = messageTemplate.clone();
        message.removeAttr('id');
        message.find('.content').html(content);
        message.find('.sender').html(sender);
        message.find('.date').html(createdAt); 
        return message;
    }
</script>