var InputModal = Vue.extend({

    template: document.getElementById('input-modal'),

    data: function () {
        return {
            tags: [],
            clickedTag: null
        };
    },

    methods: {
        initEvents: function() {
            this.$on('openInputModal', this.openInputModal.bind(this));
        },

        openInputModal: function(tags, clickedTag) {
            this.tags = [];
            this.clickedTag = clickedTag;
            $.each(tags, function(i, e) {
                this.tags.push({'trans' : e, 'value': this.clickedTag.attr(i), 'id': i});
            }.bind(this));
            $(this.$el).modal('show');
        },

        save: function () {
            $.each(this.tags, function(i, e) {
                this.clickedTag.attr(e.id, e.value);
            }.bind(this));
            var mceContentId = this.clickedTag.parents('.mce-content-body').attr('id');
            tinyMCE.EditorManager.get(mceContentId).focus();
        }
    },

    ready: function () {
        this.initEvents();
    }
});

Vue.component('input-modal', InputModal);