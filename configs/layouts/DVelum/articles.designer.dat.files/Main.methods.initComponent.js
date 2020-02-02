// add designer elements
this.addDesignerItems();

// set module permissions
this.setCanEdit(this.canEdit || false);
this.setCanDelete(this.canDelete || false);
this.setCanPublish(this.canPublish || false);

this.draftStore =  this.childObjects.draftView.getStore();
this.publishedStore = this.childObjects.publishedView.getStore();

// Set Extra params for Article Cards stores
this.draftStore.proxy.setExtraParam('filter[published]', 0);
this.publishedStore.proxy.setExtraParam('filter[published]', 1);

// Load article cards
this.draftStore.load();
this.publishedStore.load();

// Record options for views
this.childObjects.draftView.recordOptions = {'published' : false};
this.childObjects.publishedView.recordOptions = {'published' : true};
                                             
// Article cart tools events
this.childObjects.draftView.on('editCall', function(record){
	this.showEditWindow(record.get('id'));
},this);
this.childObjects.publishedView.on('editCall', function(record){
	this.showEditWindow(record.get('id'));
},this);
this.callParent();