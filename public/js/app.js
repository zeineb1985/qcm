// ajouter des élements de formulaire repponse
var $collectionHolder

var $addNewItem = $(
  '<a href="#" class="btn btn-info">Ajouter nouvelle réponse</a>',
)
$(document).ready(function () {
  // ajouter de nouveau élements à notre collectionHolder
  $collectionHolder = $('#exp_list')
  $collectionHolder.append($addNewItem)
  $collectionHolder.data('index', $collectionHolder.find('.panel').length)

  $collectionHolder.find('.panel').each(function () {
    addRemoveButton($(this))
  })
  // ajouter une fonction qui pemet d'ajouter des élements
  $addNewItem.click(function (e) {
    e.preventDefault

    addNewForm()
  })
})

// fonction qui permet d'jouter les formulaires
function addNewForm() {
  var prototype = $collectionHolder.data('prototype')
  var index = $collectionHolder.data('index')
  var newForm = prototype
  newForm = newForm.replace(/__name__/g, index)
  $collectionHolder.data('index', index+1)
  // création panel
  var $panel = $(
    '<div class="panel panel-warning"><div class="panel-heading"></div></div>',
  )
  var $panelBody = $('<div class="panel-body"></div>').append(newForm)
  $panel.append($panelBody)
  addRemoveButton($panel)
  $addNewItem.before($panel)
}

// supprimer des élements

function addRemoveButton($panel) {
  // créer le bouton de suppression // ajouter le bouton au footer de notre panel
  var $removeButton = $(
    '<a href="#" class="btn btn-danger">Supprimer réponse</a>',
  )
  var $panelFooter = $('<div class="panel-footer"></div>').append($removeButton)

  $removeButton.click(function (e) {
    $(e.target)
      .parents('.panel')
      .slideUp(700, function () {
        $(this).remove()
      })
  })

  $panel.append($panelFooter)
}
