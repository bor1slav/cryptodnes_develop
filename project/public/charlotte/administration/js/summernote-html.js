(function (factory) {
    if (typeof define === 'function'&&define.amd) {
        define(['jquery'], factory)
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory(require('jquery'));
    } else {
        factory(window.jQuery)
    }
}
(function ($) {
    $.extend(true,$.summernote.lang, {
        'en-US': {
            htmlPlugin: {
                tooltip:     'HTML Blocks',
                dialogTitle: 'Import HTML Block',
                editBtn:     'Import'
            },
        }
    });
    $.extend($.summernote.options, {
        htmlPlugin: {
            icon: '<i class="fa fa-html5"></i>',
            insertDetails: false,
        },
    });
    $.extend($.summernote.plugins, {
        'htmlPlugin': function (context) {
            var self      = this;
            var ui        = $.summernote.ui;
            var $note     = context.layoutInfo.note;
            var $editor   = context.layoutInfo.editor;
            var $editable = context.layoutInfo.editable;
            var options   = context.options;
            var lang      = options.langInfo;
            context.memo('button.htmlPlugin', function () {
                var button = ui.button({
                    contents: options.htmlPlugin.icon,
                    tooltip:  lang.htmlPlugin.tooltip,
                    click:    function (e) {
                        context.invoke('htmlPlugin.show');
                    }
                });
                return button.render();
            });
            this.initialize = function () {
                var $container = options.dialogsInBody ? $(document.body) : $editor;
                var body       = `
                   <div class="note-form-group form-group note-group-imageAttributes-role m-b-0">
                   <div class="input-group note-input-group col-xs-12 m-b-0">
                    <textarea class="form-control twitter-input" style="resize: vertical;min-height: 250px;"></textarea>
                   </div>
                   </div>
                    `;
                this.$dialog   = ui.dialog({
                    title:  lang.htmlPlugin.dialogTitle,
                    body:   body,
                    footer: '<button href="#" class="btn btn-primary note-htmlPlugin-btn">' + lang.htmlPlugin.editBtn + '</button>'
                }).render().appendTo($container);
            };
            this.destroy = function () {
                ui.hideDialog(this.$dialog);
                this.$dialog.remove();
            };
            this.bindEnterKey = function ($input,$btn) {
                $input.on('keypress',function (event) {
                    if (event.keyCode === 13) $btn.trigger('click');
                });
            };
            this.bindLabels = function () {
                self.$dialog.find('.form-control:first').focus().select();
                self.$dialog.find('label').on('click',function () {
                    $(this).parent().find('.form-control:first').focus();
                });
            };
            this.show = function () {
                this.showhtmlPluginDialog();
            };
            this.showhtmlPluginDialog = function () {
                return $.Deferred(function (deferred) {
                    var $pTBtn = self.$dialog.find('.note-htmlPlugin-btn');
                    ui.onDialogShown(self.$dialog, function () {
                        context.triggerEvent('dialog.shown');
                        $pTBtn.click(function (e) {
                            e.preventDefault();
                            $html = $('.twitter-input').val();
                            $('.twitter-input').val('');
                            $note.summernote('editor.saveRange');
                            $note.summernote('editor.restoreRange');
                            $note.summernote('editor.focus');
                            $note.summernote('editor.pasteHTML', $html);

                            // $note.summernote('code', $note.summernote('code'));
                            //
                            ui.hideDialog(self.$dialog);
                            $editable.trigger('focus');
                        });
                        self.bindEnterKey($pTBtn);
                        self.bindLabels();

                    });
                    this.destroy = function () {
                        ui.hideDialog(this.$dialog);
                        this.$dialog.remove();
                    };
                    ui.onDialogHidden(self.$dialog, function () {
                        $pTBtn.off('click');
                        if (deferred.state() === 'pending') deferred.reject();
                    });
                    ui.showDialog(self.$dialog);
                });
            };
        }
    });
}));