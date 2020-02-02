this.childObjects.draftView.getStore().proxy.setExtraParam(param, value);
this.childObjects.publishedView.getStore().proxy.setExtraParam(param, value);

this.childObjects.draftView.getStore().loadPage(1);
this.childObjects.publishedView.getStore().loadPage(1);