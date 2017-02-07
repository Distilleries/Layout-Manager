var SliderModal = Vue.extend({

    template: document.getElementById('slider-modal'),

    data: function () {
        return {
            inputs: [],
            slides: null,
            cssClass: null,
            slideTemplate: null,
            callbackUpdate: null
        };
    },

    methods: {
        initEvents: function () {
            this.$on('openSliderModal', this.openSliderModal.bind(this));
        },

        getFullHtml: function(e) {
            return $("<div />").append($(e).clone()).html();
        },

        showSlideWithContainer: function(slideHtml) {
            var slide = $(this.container);
            var slideContainer = slide.find('.template-slide').parent();
            slide.find('.template-slide').remove();
            slideContainer.html(slideHtml);
            return this.getFullHtml(slide);
        },

        openSliderModal: function (container, cssClass, callbackUpdate) {
            this.inputs = [];
            this.callbackUpdate = callbackUpdate;
            this.cssClass = cssClass;
            this.slides = [];
            $(container).find('.template-slide').each(function(i,e){
                $(e).addClass('template-slide-show');
                this.slides.push(this.getFullHtml(e));
            }.bind(this));
            this.slideTemplate = this.getFullHtml(this.slides[0]);
            this.container = this.getFullHtml(container);
            $(this.slides[0]).find('.template-image').each(function (i, e) {
                this.inputs.push({'trans': $(e).data('title'), 'upload': true, 'value': '', 'css': '.' + $(e).attr('class').replace(/\s/g, '.'), 'id': i});
            }.bind(this));

            this.$nextTick(function () {
                this.refreshSortable();
            }.bind(this));

            $(this.$el).modal('show');
        },

        refreshSortable: function() {
            new Sortable($(this.$el).find('.sortable')[0], {
                onEnd: this.onSortEnd.bind(this),
                animation: 150
            });
        },

        onSortEnd: function (event) {
            event.item.remove();
            var item = this.slides.splice(event.oldIndex, 1)[0];
            this.slides.splice(event.newIndex, 0, item);
            this.$nextTick(this.reorder.bind(this));
        },

        reorder: function () {
            var newArray = this.slides.slice();
            this.slides = false;
            this.$nextTick(function(){
                this.slides = [];
                for (var i = 0; i < newArray.length; i++) {
                    var newPanel = (' ' + newArray[i]).slice(1);
                    this.slides[i] = newPanel;
                }
            }.bind(this));
        },

        addSlide: function () {
            var newSlide = $(this.getFullHtml(this.slideTemplate));
            $.each(this.inputs, function (i, e) {
                var update = $($(newSlide).find(e.css));
                if (update.is('img')) {
                    update.attr('src', $('#slide_tag_'+ i).val());
                } else {
                    update.css('backgroundImage', "url('" + $('#slide_tag_'+ i).val() + "')");
                }
                $('#slide_tag_'+ i).val('');
            }.bind(this));

            this.slides.unshift(this.getFullHtml(newSlide));
            var newSlides = [];
            $.each(this.slides, function(i,e){
                newSlides.push(e);
            }.bind(this));
            this.slides = newSlides;

            this.$nextTick(function () {
                this.refreshSortable();
            }.bind(this));
        },

        remove: function (slideIndex) {
            this.slides.splice(slideIndex,1);
            this.$nextTick(function () {
                this.refreshSortable();
            }.bind(this));
        },

        save: function () {
            this.callbackUpdate(this.slides);
        }
    },

    ready: function () {
        this.initEvents();
    }
});

Vue.component('slider-modal', SliderModal);