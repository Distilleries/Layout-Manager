var TemplatePortlet = Vue.extend({

    template: document.getElementById('portlet-template'),

    props: ['panel'],

    data: function () {
        return {
            panel: null,
            _contentID: null,
            resetContent: null
        };
    },

    computed: {
        'contentID': function () {
            if (!this._contentID) {
                this._contentID = jQuery('#' + this.guid + ' .portlet-body .templatable').attr('id');
            }
            return this._contentID;
        },
        
        'guid': function () {
            if (!this.panel.guid) {
                this.panel.guid = this.generateGuid();
            }
            return this.panel.guid;
        }
    },

    methods: {
        disabledAdd: function (category) {
            if (window.disableAdd === false) return true;
            if (window.disableAdd === true) return false;
            if ($.inArray(category, window.disableAdd) >=0) return false;
            return true;
        },
        reset: function () {
            $('#confirmationModal').modal('show');
            $('#confirmationModal #confirmationButton').off('click').on('click', function () {
                tinymce.remove(this.contentID);
                this.$el.querySelector('.templatable').innerHTML = this.resetContent;
                this.initTinyMCE();
            }.bind(this));
        },

        remove: function () {
            $('#confirmationModal').modal('show');
            $('#confirmationModal #confirmationButton').off('click').on('click', function () {
                this.$dispatch('onRemove', this.panel);
            }.bind(this));
        },

        duplicate: function () {
            $('#confirmationModal').modal('show');
            $('#confirmationModal #confirmationButton').off('click').on('click', function () {
                this.$dispatch('onDuplicate', this.panel);
            }.bind(this));
        },

        blurred: function () {
            this.panel.pivot.html = tinymce.get(this.contentID).getContent();
            this.$dispatch('onEdit', this.panel);
        },

        initTinyMCE: function () {
            this.resetContent = this.panel.pivot.html;
            var validExtentions = '';
            var j = 0;

            $.each(window.customTags, function (key, e) {
                if (j > 0) validExtentions = validExtentions + ',';
                validExtentions = validExtentions + key + 'end' + ',' + key + 'start';
                j++;
            });

            tinymce.init({
                selector: '#' + this.guid + ' .portlet-body .templatable',
                inline: true,
                menubar: false,
                forced_root_block: false,
                toolbar: this.panel.toolbar,
                convert_urls: false,
                verify_html: false,
                extended_valid_elements: validExtentions,
                custom_elements: validExtentions,
                plugins: this.panel.plugins ? this.panel.plugins : [],
                init_instance_callback: function (editor) {
                    editor.on('blur', function (e) {
                        this.blurred();
                    }.bind(this));
                }.bind(this)
            });
        },

        hash: function () {
            return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
        },

        generateGuid: function () {
            return this.hash() + this.hash() + '-' + this.hash() + '-' + this.hash() + '-' + this.hash() + '-' + this.hash() + this.hash() + this.hash();
        }
    },

    ready: function () {
        this.initTinyMCE();
    }

});

Vue.component('portlet-panel', TemplatePortlet);