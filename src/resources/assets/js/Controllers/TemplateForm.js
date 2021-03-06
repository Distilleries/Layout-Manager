new Vue({

    el: '#template',

    data: function () {
        return {
            panels: null,
            inputModal: null
        };
    },

    methods: {
        disabledAdd: function (category) {
            if (window.disableAdd === false) return true;
            if (window.disableAdd === true) return false;
            if ($.inArray(category, window.disableAdd) >= 0) return false;
            return true;
        },
        initSortable: function () {
            $(".sortable .tab-pane").each(function (index, el) {
                new Sortable($(el)[0], {
                    handle: ".btn-draggable",  // Drag handle selector within list items+
                    filter: ".portlet-sortable-empty, .portlet-fullscreen",  // Selectors that do not lead to dragging (String or Function)
                    draggable: ".portlet-sortable",  // Specifies which items inside the element should be draggable
                    ghostClass: "portlet-sortable-placeholder",  // Class name for the drop placeholder
                    onEnd: this.onSortEnd.bind(this),
                    animation: 150
                });
            }.bind(this));
        },


        onSortEnd: function (evt) {
            this.panels.splice(evt.newIndex -1, 0, this.panels.splice(evt.oldIndex -1, 1)[0]);
            this.refreshPivotOrders();
        },

        initAddTemplate: function () {
            $('.btn-valid-add').click(this.onAdd.bind(this));
        },

        reorder: function () {
            this.refreshPivotOrders();
        },

        refreshPivotOrders: function() {
            for (var i = 0; i < this.panels.length; i++) {
                // The pivot's order is updated
                var newPivot = $.extend(true, {}, this.panels[i].pivot, {'order': i});
                var newPanel = $.extend(true, {}, this.panels[i], {'pivot': newPivot});
                // The panels array MUST be tagged as dirty to trigger a vue rerendering
                this.panels[i] = newPanel;
            }
        },

        onAdd: function (e) {
            var select = $(e.currentTarget).siblings('.template-select');
            var selected = select.val();
            var templateFound = null;
            $.each(window.templates, function (index, e) {
                if (e.id == selected) {
                    templateFound = e;
                }
            });
            var cat = select.data('category');
            if (templateFound) {
                var extension = {
                    'pivot': {
                        'html': templateFound.html,
                        'template_id': templateFound.id,
                        'order': 0,
                        'status': 1
                    }
                };
                if (cat) {
                    extension.pivot.category = cat;
                }
                templateFound = $.extend(true, {}, templateFound, extension);
                this.panels.unshift(templateFound);
                this.lastScrollPos = $(window).scrollTop();
                this.$nextTick(this.reorder.bind(this));
            }
        },

        onRemove: function (panel) {
            for (var i = 0; i < this.panels.length; i++) {
                if (this.panels[i].guid == panel.guid) {
                    this.panels.splice(i, 1);
                    this.lastScrollPos = $(window).scrollTop();
                    this.$nextTick(this.reorder.bind(this));
                    break;
                }
            }
        },

        onEdit: function (panel) {
            for (var i = 0; i < this.panels.length; i++) {
                if (this.panels[i].guid == panel.guid) {
                    this.panels[i].pivot.html = panel.pivot.html;
                    this.panels[i].pivot.libelle = panel.pivot.libelle;
                    break;
                }
            }
        },

        onDuplicate: function (panel) {
            for (var i = 0; i < this.panels.length; i++) {
                if (this.panels[i].guid == panel.guid) {
                    var newPanel = $.extend(true, {}, panel);
                    newPanel.pivot.id = null;
                    newPanel.guid = null;
                    this.panels.splice(i, 0, newPanel);
                    this.lastScrollPos = $(window).scrollTop();
                    this.$nextTick(this.reorder.bind(this));
                    break;
                }
            }
        },

        initEvents: function () {
            this.$on('onRemove', this.onRemove.bind(this));
            this.$on('onDuplicate', this.onDuplicate.bind(this));
            this.$on('onEdit', this.onEdit.bind(this));
        },

        overrideSubmit: function () {
            $(this.$el).parents('form').on('submit', this.onSubmit.bind(this));
        },

        onSubmit: function (e) {
            this.$http.post('/api/template/save', {
                'templatables': this.panels,
                'templatable_type': templatable_type,
                'templatable_id': templatable_id
            }).then(function () {
                $("#template").parents('form').off('submit').submit();
            });
            e.preventDefault();
            return false;
        },

        initImageHandler: function () {
            $(this.$el).on('click', '.template-image', function () {
                moxman.browse({
                    no_host: true,
                    oninsert: function (moxi) {
                        if ($(this).is('img')) {
                            $(this).attr('src', moxi.focusedFile.path);
                            $(this).attr('data-mce-src', moxi.focusedFile.path);
                        } else {
                            $(this).css('backgroundImage', 'url("' + moxi.focusedFile.path + '")');
                            $(this).attr('data-mce-style', 'background-image: url("' + moxi.focusedFile.path + '");');
                        }
                        tinyMCE.activeEditor.insertContent(tinyMCE.activeEditor.selection.getContent({format: 'html'}));
                        tinyMCE.activeEditor.focus();
                    }.bind(this)
                });
            });
        },

        initCustomTagsHandler: function () {
            $.each(window.customTags, function (key, tagArgs) {
                $(this.$el).on('click', key, function (e) {
                    this.$broadcast('openInputModal', tagArgs, $(e.target));
                }.bind(this));
            }.bind(this))
        }
    },

    computed: {
        "orderedPanels": function() {
            this.panels.sort(function(a, b) {
                if(a.pivot.order < b.pivot.order) return -1;
                else if(b.pivot.order < a.pivot.order) return 1;
                return 0;
            });
            return this.panels;
        }
    },

    ready: function () {
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.panels = window.templatables;
        this.initSortable();
        this.initAddTemplate();
        this.initEvents();
        this.initImageHandler();
        this.initCustomTagsHandler();
        this.overrideSubmit();
    }

});