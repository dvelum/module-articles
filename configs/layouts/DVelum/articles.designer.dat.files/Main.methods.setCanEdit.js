this.canEdit = canEdit;
if(canEdit){
  this.childObjects.addButton.show();
}else{
  this.childObjects.addButton.hide();
}
//this.childObjects.draftView.refresh();
//this.childObjects.publishedView.refresh();