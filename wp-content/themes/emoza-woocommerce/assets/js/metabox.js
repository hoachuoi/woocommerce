"use strict";

;
(function ($) {
  'use strict';

  $.fn.emozaMetabox = function () {
    return this.each(function () {
      var $this = $(this);
      var $tabs = $this.find('.emoza-metabox-tab');
      var $contents = $this.find('.emoza-metabox-content');
      $tabs.each(function () {
        var $tab = $(this);
        $tab.on('click', function (e) {
          e.preventDefault();
          var $content = $contents.eq($tab.index());
          $tab.addClass('active').siblings().removeClass('active');
          $content.addClass('active').siblings().removeClass('active');
          $(document).trigger('emoza-metabox-content-show', $content);
        });
      });
      var $repeater = $contents.find('.emoza-metabox-field-repeater');
      if ($repeater.length) {
        $repeater.each(function () {
          var $list = $(this).find('ul');
          $list.sortable({
            axis: 'y',
            cursor: 'move',
            helper: 'original',
            handle: '.emoza-metabox-field-repeater-move'
          });
          $repeater.find('.emoza-metabox-field-repeater-add').on('click', function (e) {
            e.preventDefault();
            var $item = $list.find('li').first().clone(true);
            var $input = $item.find('input');
            $input.attr('name', $input.data('name'));
            $item.removeClass('hidden');
            $list.append($item);
          });
          $repeater.find('.emoza-metabox-field-repeater-remove').on('click', function (e) {
            e.preventDefault();
            $(this).closest('li').remove();
          });
        });
      }
      var $uploads = $contents.find('.emoza-metabox-field-uploads');
      if ($uploads.length) {
        $uploads.each(function () {
          var $list = $(this).find('ul');
          $list.sortable({
            axis: 'y',
            cursor: 'move',
            helper: 'original',
            handle: '.emoza-metabox-field-uploads-move'
          });
          $uploads.find('.emoza-metabox-field-uploads-add').on('click', function (e) {
            e.preventDefault();
            var $items = $list.find('li');
            var $item = $items.first().clone(true);
            $item.find('input').each(function () {
              $(this).attr('name', $(this).data('name').replace('0', $items.length));
            });
            $item.removeClass('hidden');
            $list.append($item);
          });
          var wpMediaFrame;
          var wpMediaInput;
          $uploads.find('.emoza-metabox-field-uploads-upload').on('click', function (e) {
            e.preventDefault();
            wpMediaInput = $(this).closest('li').find(' > input');
            if (wpMediaFrame && wpMediaFrame.options.library.type === $list.data('library')) {
              wpMediaFrame.open();
              return;
            }
            wpMediaFrame = window.wp.media({
              library: {
                type: $list.data('library') || 'image'
              }
            }).open();
            wpMediaFrame.on('select', function () {
              var attachment = wpMediaFrame.state().get('selection').first().toJSON();
              wpMediaInput.val(attachment.url);
            });
          });
          $uploads.find('.emoza-metabox-field-uploads-thumbnail-upload').on('click', function (e) {
            e.preventDefault();
            wpMediaInput = $(this).parent().find('input');
            if (wpMediaFrame && wpMediaFrame.options.library.type === 'image') {
              wpMediaFrame.open();
              return;
            }
            wpMediaFrame = window.wp.media({
              library: {
                type: 'image'
              }
            }).open();
            wpMediaFrame.on('select', function () {
              var attachment = wpMediaFrame.state().get('selection').first().toJSON();
              var thumbnail = wpMediaInput.parent();
              wpMediaInput.val(attachment.id);
              thumbnail.find('span').hide();
              thumbnail.find('img').remove();
              thumbnail.find('.emoza-metabox-field-uploads-thumbnail-remove').show();
              thumbnail.find('.emoza-metabox-field-uploads-thumbnail-upload').append($('<img>').attr({
                'src': attachment.url
              }));
            });
          });
          $uploads.find('.emoza-metabox-field-uploads-thumbnail-remove').on('click', function (e) {
            e.preventDefault();
            var thumbnail = $(this).parent();
            thumbnail.find('span').show();
            thumbnail.find('img').remove();
            thumbnail.find('input').val('');
            thumbnail.find('.emoza-metabox-field-uploads-thumbnail-remove').hide();
          });
          $uploads.find('.emoza-metabox-field-uploads-remove').on('click', function (e) {
            e.preventDefault();
            $(this).closest('li').remove();
          });
        });
      }
      var $sizeChart = $contents.find('.emoza-metabox-field-size-chart');
      if ($sizeChart.length) {
        $sizeChart.on('multidimensional', function (event, $table) {
          var $wrap = $table || $sizeChart;
          $wrap.find('input').each(function () {
            var $input = $(this);
            var liIndex = Math.max(0, $input.closest('li').index() - 1);
            var trIndex = Math.max(0, $input.closest('tr').index() - 1);
            var tdIndex = Math.max(0, $input.closest('td').index());
            this.name = this.name.replace(/(\[\d+\])\[sizes\](\[\d+\])(\[\d+\])/, '[' + liIndex + '][sizes][' + trIndex + '][' + tdIndex + ']');
            this.name = this.name.replace(/(\[\d+\])\[name\]/, '[' + liIndex + '][name]');
          });
        });
        $sizeChart.each(function () {
          var $list = $(this).find('ul');
          $sizeChart.on('click', '.emoza-add', function (e) {
            e.preventDefault();
            var $item = $list.find('li').first().clone(true);
            var $input = $item.find('input');
            $input.each(function () {
              $(this).attr('name', $(this).data('name'));
              $(this).removeAttr('data-name');
            });
            $item.removeClass('hidden');
            $list.append($item);
            $sizeChart.trigger('multidimensional', [$item]);
          });
          $sizeChart.on('click', '.emoza-add-col', function (e) {
            e.preventDefault();
            var $td = $(this).closest('td');
            var $table = $(this).closest('table');
            var $columns = $(this).closest('tbody').find('tr td:nth-child(' + ($td.index() + 1) + ')');
            $columns.each(function () {
              var $column = $(this);
              var $clone = $column.clone(true);
              $clone.find('input').val('');
              $column.after($clone);
            });
            $sizeChart.trigger('multidimensional', [$table]);
          });
          $sizeChart.on('click', '.emoza-del-col', function (e) {
            e.preventDefault();
            var $td = $(this).closest('td');
            var $table = $(this).closest('table');
            var $count = $(this).closest('tr').find('td').length;
            var $target = $(this).closest('tbody').find('tr td:nth-child(' + ($td.index() + 1) + ')');
            if ($count > 2) {
              $target.remove();
            } else {
              $target.find('input').val('');
            }
            $sizeChart.trigger('multidimensional', [$table]);
          });
          $sizeChart.on('click', '.emoza-add-row', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            var $table = $(this).closest('table');
            var $clone = $tr.clone(true);
            $clone.find('input').val('');
            $tr.after($clone);
            $sizeChart.trigger('multidimensional', [$table]);
          });
          $sizeChart.on('click', '.emoza-del-row', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            var $table = $(this).closest('table');
            var $count = $(this).closest('tbody').find('tr').length;
            if ($count > 2) {
              $tr.remove();
            } else {
              $tr.find('input').val('');
            }
            $sizeChart.trigger('multidimensional', [$table]);
          });
          $sizeChart.on('click', '.emoza-remove', function (e) {
            e.preventDefault();
            $(this).closest('li').remove();
            $sizeChart.trigger('multidimensional');
          });
          $sizeChart.on('click', '.emoza-duplicate', function (e) {
            e.preventDefault();
            var $li = $(this).closest('li');
            var $clone = $li.clone(true);
            $li.after($clone);
            $sizeChart.trigger('multidimensional');
          });
        });
      }
      var $mediaField = $('.emoza-metabox-field-media');
      if ($mediaField.length) {
        $mediaField.each(function () {
          var $field = $(this);
          var $input = $field.find('.emoza-metabox-field-media-input');
          var $image = $field.find('.emoza-metabox-field-media-preview img');
          var $upload = $field.find('.emoza-metabox-field-media-upload');
          var $remove = $field.find('.emoza-metabox-field-media-remove');
          var placeholder = $image.data('placeholder');
          var wpMediaFrame;
          $upload.on('click', function (e) {
            e.preventDefault();
            if (wpMediaFrame) {
              wpMediaFrame.open();
              return;
            }
            wpMediaFrame = window.wp.media({
              library: {
                type: 'image'
              }
            });
            wpMediaFrame.on('select', function () {
              var attachment = wpMediaFrame.state().get('selection').first().toJSON();
              var thumbnail;
              if (attachment && attachment.sizes && attachment.sizes.thumbnail) {
                thumbnail = attachment.sizes.thumbnail.url;
              } else {
                thumbnail = attachment.url;
              }
              $input.val(attachment.id);
              $image.attr('src', thumbnail);
              $remove.removeClass('hidden');
            });
            wpMediaFrame.open();
          });
          $remove.on('click', function (e) {
            e.preventDefault();
            $input.val('');
            $image.attr('src', placeholder);
            $remove.addClass('hidden');
          });
        });
      }
      var $selectAjax = $('.emoza-metabox-field-select-ajax');
      if ($selectAjax.length) {
        $selectAjax.each(function () {
          var $select = $(this).find('select');
          var source = $select.data('source');
          var config = window.emoza_metabox;
          $select.select2({
            width: '100%',
            minimumInputLength: 1,
            ajax: {
              url: config.ajaxurl,
              dataType: 'json',
              delay: 250,
              cache: true,
              data: function data(params) {
                return {
                  action: 'emoza_select_ajax',
                  nonce: config.ajaxnonce,
                  term: params.term,
                  source: source
                };
              },
              processResults: function processResults(response, params) {
                if (response.success) {
                  return {
                    results: response.data
                  };
                }
                return {};
              }
            }
          });
          $selectAjax.find('.select2-selection--multiple').append('<span class="emoza-select2-clear"></span>');
        });
      }
      var $attributes = $('.emoza-metabox-field-wc-attributes');
      if ($attributes.length) {
        $attributes.each(function () {
          var $sortable = $(this).find('ul');
          $sortable.sortable({
            axis: 'y',
            cursor: 'move',
            helper: 'original'
          });
        });
      }
      $(document).on('emoza-metabox-content-show', function (event, content) {
        var $content = $(content);
        if (!$content.data('code-editor-initalized')) {
          var $codeEditors = $('.emoza-metabox-field-code-editor', $content);
          if ($codeEditors.length) {
            $codeEditors.each(function () {
              var $textarea = $(this).find('textarea');
              var editorSettings = wp.codeEditor.defaultSettings || {};
              editorSettings.codemirror = _.extend({}, editorSettings.codemirror, {
                gutters: []
              });
              var editor = wp.codeEditor.initialize($textarea, editorSettings);
              editor.codemirror.on('keyup', function (instance) {
                instance.save();
              });
            });
          }
          $content.data('code-editor-initalized', true);
        }
      });
      var $depends = $contents.find('[data-depend-on]');
      if ($depends.length) {
        $depends.each(function () {
          var $depend = $(this);
          var $target = $contents.find('[name="' + $depend.data('depend-on') + '"]');
          if (!$target.data('depend-on')) {
            $target.on('change', function () {
              var $dependOn = $contents.find('[data-depend-on="' + $depend.data('depend-on') + '"]');
              if ($(this).is(':checked')) {
                $dependOn.removeClass('emoza-metabox-field-hidden');
              } else {
                $dependOn.addClass('emoza-metabox-field-hidden');
              }
            });
            $target.data('depend-on', true);
          }
        });
      }
    });
  };
  $(document).ready(function ($) {
    $('.emoza-metabox').emozaMetabox();
  });
})(jQuery);