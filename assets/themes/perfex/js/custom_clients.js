$(function() {
    var ServID = $('input[name="ServID_for_clients"]').val();
if (typeof(discussion_id != 'undefined')) {
    custom_discussion_comments('#custom-discussion-comments', discussion_id, 'regular', ServID);
}
});

function custom_discussion_comments(selector, discussion_id, discussion_type, ServID) {
    var defaults = _get_jquery_comments_default_config(app.lang.discussions_lang);

    var options = {
        getComments: function(success, error) {
            $.post(site_url + 'clients/legal_services/' + project_id + '/' + ServID, {
                action: 'discussion_comments',
                discussion_id: discussion_id,
                discussion_type: discussion_type,
            }).done(function(response) {
                response = JSON.parse(response);
                success(response);
            });
        },
        postComment: function(commentJSON, success, error) {
            commentJSON.action = 'new_discussion_comment';
            commentJSON.discussion_id = discussion_id;
            commentJSON.discussion_type = discussion_type;
            $.ajax({
                type: 'post',
                url: site_url + 'clients/legal_services/' + project_id + '/' + ServID,
                data: commentJSON,
                success: function(comment) {
                    comment = JSON.parse(comment);
                    success(comment)
                },
                error: error
            });
        },
        putComment: function(commentJSON, success, error) {
            commentJSON.action = 'update_discussion_comment';
            $.ajax({
                type: 'post',
                url: site_url + 'clients/legal_services/' + project_id + '/' + ServID,
                data: commentJSON,
                success: function(comment) {
                    comment = JSON.parse(comment);
                    success(comment)
                },
                error: error
            });
        },
        deleteComment: function(commentJSON, success, error) {
            $.ajax({
                type: 'post',
                url: site_url + 'clients/legal_services/' + project_id + '/' + ServID,
                success: success,
                error: error,
                data: {
                    id: commentJSON.id,
                    action: 'delete_discussion_comment'
                }
            });
        },
        uploadAttachments: function(commentArray, success, error) {
            var responses = 0;
            var successfulUploads = [];

            var serverResponded = function() {
                responses++;
                // Check if all requests have finished
                if (responses == commentArray.length) {
                    // Case: all failed
                    if (successfulUploads.length == 0) {
                        error();
                        // Case: some succeeded
                    } else {
                        successfulUploads = JSON.parse(successfulUploads);
                        success(successfulUploads)
                    }
                }
            }
            $(commentArray).each(function(index, commentJSON) {
                if (commentJSON.file.size && commentJSON.file.size > app.max_php_ini_upload_size_bytes) {
                    alert_float('danger', app.lang.file_exceeds_max_filesize);
                    serverResponded();
                } else {
                    // Create form data
                    var formData = new FormData();
                    $(Object.keys(commentJSON)).each(function(index, key) {
                        var value = commentJSON[key];
                        if (value) formData.append(key, value);
                    });

                    formData.append('action', 'new_discussion_comment');
                    formData.append('discussion_id', discussion_id);
                    formData.append('discussion_type', discussion_type);

                    if (typeof(csrfData) !== 'undefined') {
                        formData.append(csrfData['token_name'], csrfData['hash']);
                    }

                    $.ajax({
                        url: site_url + 'clients/legal_services/' + project_id + '/' + ServID,
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(commentJSON) {
                            successfulUploads.push(commentJSON);
                            serverResponded();
                        },
                        error: function(data) {
                            var error = JSON.parse(data.responseText);
                            alert_float('danger', error.message);
                            serverResponded();
                        },
                    });
                }
            });
        }
    };

    var settings = $.extend({}, defaults, options);

    $(selector).comments(settings);
}