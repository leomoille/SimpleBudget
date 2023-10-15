import a2lix_lib from '@a2lix/symfony-collection/dist/a2lix_sf_collection.min'

a2lix_lib.sfCollection.init({
  collectionsSelector: 'form div[data-prototype]',
  manageRemoveEntry: true,
  entry: {
    add: {
      prototype:
          '<button class="__class__" data-entry-action="add">__label__</button>',
      class: 'btn btn-primary',
      label: 'Ajouter une entrée',
      customFn: null,
      onBeforeFn: null,
      onAfterFn: null
    },
    remove: {
      prototype:
          '<button class="__class__" data-entry-action="remove">__label__</button>',
      class: 'btn btn-danger',
      label: 'Supprimer',
      customFn: null,
      onAfterFn: null
    }
  }
})
