<div class="portlet portlet-sortable light bordered" :id="guid">
    <div class="portlet-title">
        <div class="caption font-green-sharp">
            <i class="icon-speech font-green-sharp"></i>
            <span class="caption-subject">  @{{panel.libelle}}</span>
        </div>
        <input v-if="panel.pivot.libelle" class="form-control font-green-sharp libelle " v-model="panel.pivot.libelle" type="text" value="Depuis près de 30 ans, Primevère vous aide à garder le contrôle sur votre cholestérol et entretenir votre santé cardiovasculaire." id="libelle">
        <div class="actions">
            <button type="button" class="btn-slider-prev btn btn-circle purple-studio " v-on:click='previousSlide()' v-if="sliderEnabled">
                <i class="fa fa-angle-left"></i> Précédent
            </button>
            <button type="button" class="btn-slider-detail btn btn-circle grey " v-on:click='showSlideDetails()' v-if="sliderEnabled">
                <i class="fa fa-list-ol"></i> Liste
            </button>
            <button type="button" class="btn-slider-next btn btn-circle purple-studio" v-on:click='nextSlide()' v-if="sliderEnabled">
                <i class="fa fa-angle-right"></i> Suivant
            </button>


            <button type="button" class="btn btn-circle red-sunglo " v-on:click='remove()' v-if="disabledAdd(panel.pivot.category)">
                <i class="fa fa-close"></i> Supprimer </button>
            <button type="button" class="btn btn-circle btn-default" v-on:click='duplicate()' v-if="disabledAdd(panel.pivot.category)">
                <i class="fa fa-clone"></i> Dupliquer
            </button>
            <button type="button" class="btn btn-circle btn-default" v-on:click='reset()' >
                <i class="fa fa-eraser"></i> Reset
            </button>
            <button type="button" class="btn btn-circle btn-icon-only btn-default btn-draggable" v-if="disabledAdd(panel.pivot.category)">
                <i class="fa fa-arrows"></i>
            </button>
            <button type="button" class="btn btn-circle btn-icon-only btn-default fullscreen">
            </button>
        </div>
    </div>
    <div class="portlet-body">
        <div class="templatable" v-html="panel.pivot.html" :class="panel.css_class">

        </div>
    </div>
</div>