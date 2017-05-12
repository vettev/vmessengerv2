require('./bootstrap');

let conversationsCount = $('.conversation').length; // Count of conversations window opened
let messaging = $('#messaging'); // Panel
let messageTemplate = $('#message-template'); // Template of 
let loggedUserName = $('#self-contact span').html(); // Username of logged user
let canOpenConversation = true; // Flag to block open same conversation
let canSendMessage = true; // Flag to block multiple same messages

$.ajaxPrefilter(function(options, originalOptions, xhr) {
      var token = $('meta[name="csrf-token"]').attr('content');
      
      if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
      }
});

$('body').on('click', '.ajax-link', function(e) 
{
	e.preventDefault();
	let href = $(this).attr('href');
	let link = $(this);
	if(link.hasClass('contact') || link.hasClass('conversation-new'))
	{
		let convElement = link.data('conv-id');
		let id = link.data('conv-id').split('-')[1];
		$("#modal").modal('hide');
		if($(convElement).length === 0 && canOpenConversation)
		{
			$.ajax({
				url: href,
				dataType: 'html',
				beforeSend: () => {
					canOpenConversation = false;
				},
				error: () => {
					canOpenConversation = true;
				},
				success: (data) => {
					if(conversationsCount == 0)
					{
						messaging.append(data);
						conversationsCount++;
					}
					else if(conversationsCount == 1)
					{
						messaging.append(data);
						conversationsCount++;
						$('#messaging .conversation').css('width', '48%');
					}
					else
					{
						$('.conversation')[0].remove();
						messaging.append(data);
						$('.conversation').css('width', '48%');
					}
					canOpenConversation = true;
				}
			}).then(() => {
				let messages = $(convElement).find('.messages');
				messages.animate({scrollTop: messages[0].scrollHeight});
				$('#contact-' + id).find('.unread').hide().html(0);

				if(link.hasClass('unread-conversation'))
				{
					$('.unread-link .unread').html('0').hide();
					$(link).remove();
				}
			});
		}
		else
		{
			$(convElement + ' form .message-input').focus();
		}
	}
	else if(link.hasClass('contact-new'))
	{
		$.ajax({
			url: href,
			success: (data) => {
				$('#contacts').append(data);
				link.remove();
			}
		});
	}
	else if(link.hasClass('user-show'))
	{
		$.ajax({
			url: href,
			success: (data) => {
				let modal = $('#modal')
				modal.modal();
				modal.find('.modal-title').html('User profile');
				modal.find('.modal-body').html(data);
			}
		});
	}
	else if(link.hasClass('user-edit'))
	{
		$.ajax({
			url: href,
			success: (data) => {
				let modal = $('#modal')
				modal.modal();
				modal.find('.modal-title').html('Edit profile');
				modal.find('.modal-body').html(data);
			}
		});
	}
	else if(link.hasClass('contact-delete'))
	{
		$.ajax({
			url: href,
			method: 'DELETE'
		}).then(() => {
			$(link.data('target')).remove();
		});
	}
	else if(link.hasClass('unread-link'))
	{
		$.ajax({
			url: '/messages/unread',
			success: (data) => {
				$('#unread').html(data);
			}
		})
	}
});

messaging.on('click', '.close-window', function() 
{
	closeConversation($(this).parent());
});

$('body').on('submit', '.ajax-form', function(e) 
{
	e.preventDefault();
	let href = $(this).attr('action');
	let form = $(this);
	if(form.hasClass('message-form'))
	{
		let input = form.find('.message-input');
		let dataToSend = form.serialize();
		if(input.val() && canSendMessage)
		{
			$.ajax({
				method: 'POST',
				url: href,
				data: form.serialize(),
				beforeSend: () => {
					canSendMessage = false;
				},
				error: () => {
					canSendMessage = true;
				},
				success: (data) => {
					let messages = form.parent().find('.messages');
					let msg = newMessage(input.val(), loggedUserName, data.created_at);
					input.val('');
					messages.animate({scrollTop: messages[0].scrollHeight});
					messages.append(msg);
					canSendMessage = true;
					if(data)
					{
						dataToSend += "&created_at=" + data.created_at;
						$.ajax({
							url: '/message/trigger',
							method: 'POST',
							data: dataToSend,
						});
					}
				}
			});
		}
	}
	else if(form.hasClass('search-form'))
	{
		let input = form.find('.form-control');
		if(input.val().length >= 2)
		{
			$.ajax({
				method: 'POST',
				url: href,
				data: form.serialize(),
				success: (data) => {
					let modal = $('#modal');
					modal.modal();
					modal.find('.modal-title').html("Search results");
					modal.find('.modal-body').html(data);
				}
			});
		}
	}
	else if(form.hasClass('user-edit'))
	{
		$.ajax({
			method: 'POST',
			url: href,
			enctype: 'multipart/form-data',
			data: new FormData(form[0]),
			cache: false,
			processData: false,
			contentType: false,
			success: (data) => {
				$('#modal').modal('hide');
			}
		});
	}
});

$('#messaging').on('focus', '.message-input', function () {
	let recipientId = $(this).prev().val();
	$.ajax({
		method: 'POST',
		url: '/messages/read',
		data: { 'recipient_id' : recipientId }
	}).then(() => {
		$('#contact-' + recipientId).find('.unread').html('0').hide();
	});
});

function closeConversation(conversation)
{
	$(conversation).remove();
	conversationsCount--;

	if(conversationsCount == 1)
	{
		$('.conversation').css('width', '100%');
	}
}

function newMessage(content, sender, createdAt)
{
	let message = messageTemplate.clone();
	message.removeAttr('id');
	message.find('.content').html(content);
	message.find('.sender').html(sender);
	message.find('.date').html(createdAt); 
	return message;
}