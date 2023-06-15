if (typeof jQuery === 'undefined') {
    throw new Error('Requires jQuery')
}
import "fine-uploader/lib/jquery/traditional";

+(function ($) {
    'use strict';

    const CSRFTOKEN = $('meta[name=_token]').attr('content');
    const BASEURL = $('meta[name=_base_url]').attr('content');

    let btn_v_upload = $('#btn_video_uploader');

    let btn_v_upload_disable = function () {
        if (!btn_v_upload.prop('disabled')) {
            $('input[name="qqfile"]').addClass('disabled').attr('disabled', 'disabled');
            btn_v_upload.addClass('disabled').attr('disabled', 'disabled').before('<i class="glyphicon glyphicon-refresh glyphicon-spin save-spinner"></i> ');
        }
    };

    let btn_v_upload_enable = function () {
        if (btn_v_upload.prop('disabled')) {
            $('.save-spinner').remove();
            $('input[name="qqfile"]').removeClass('disabled').removeAttribute('disabled');
            btn_v_upload.removeClass('disabled').removeAttribute('disabled');
        }
    };

    let vuploader = $('#video_uploader').fineUploader({
        template: "upload-template",
        thumbnails: {
            placeholders: {
                waitingPath: BASEURL + "/images/vendor/fine-uploader/fine-uploader/waiting-generic.png",
                notAvailablePath: BASEURL + "/images/vendor/fine-uploader/fine-uploader/not_available-generic.png"
            }
        },
        request: {
            endpoint: BASEURL + '/my/video/upload',
            params: {_token: CSRFTOKEN}
        },
        editFilename: {
            enabled: false
        },
        retry: {
            enableAuto: false
        },
        chunking: {
            enabled: true,
            partSize: 16777216, // 16 MB
            concurrent: {
                enabled: true
            },
            success: {
                endpoint: BASEURL + "/my/video/upload/done"
            }
        },
        deleteFile: {
            enabled: true,
            method: "DELETE",
            endpoint: BASEURL + '/my/video/delete',
            params: {_token: CSRFTOKEN}
        },
        autoUpload: false,
        validation: {
            itemLimit: 1,
            allowedExtensions: ['3gp', 'avi', 'flv', 'm4v', 'mov', 'mp4', 'mpeg', 'mpg', 'vob', 'webm', 'wmv'],
            sizeLimit: 4294967296 // 4 Gb
        },
        callbacks: {

            onError: function (id, name, errorReason) {
                $('.upload-error').removeClass('hidden');
                $('.error-msg').text('Error: ' + errorReason);
                btn_v_upload_enable();
            },

            onUpload: function (id, name) {
                btn_v_upload_disable();
            },

            onComplete: function (id, name, response) {
                if (response.success) {
                    $('.upload-error').addClass('hidden');
                    $('.error-msg').text('');

                    let fileEl = vuploader.fineUploader("getItemByFileId", id),
                        imageEl = fileEl.find(".uploaded-file");

                    imageEl.append('<input name="filename" type="hidden" value="' + name + '">');
                    imageEl.append('<input name="uuid" type="hidden" value="' + response.uuid + '">');
                } else {
                    btn_v_upload_enable();
                }
            },

            onAllComplete: function (s, f) {
                if (s.length > 0) {
                    $('#form_upload').submit();
                }
            }
        }
    });

    btn_v_upload.click(function (e) {
        let title = $("#form_upload input[name='title']").val();
        let description = $("#form_upload textarea[name='description']").val();

        if (title == "" || description == "") {
            swal(
                'Error!',
                'Video Title and Description are required!',
                'error'
            )
        } else {
            vuploader.fineUploader('uploadStoredFiles');
        }

        e.preventDefault();
    });
})(jQuery);