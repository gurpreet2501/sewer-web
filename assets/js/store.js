window.Store = {
	query: function(entityNameOrArr){
		return new Query(entityNameOrArr);
	}
};

function Query(entityNameOrArr){
	this.entityNameOrArr = entityNameOrArr;

	this.rows = null;
	if(entityNameOrArr.constructor === Array)
		this.rows = entityNameOrArr;

	if(!this.rows)
		this.rows = window.for_js[this.entityNameOrArr];

	if(!this.rows)
		throw "Invalid Input, Query only accepts Array as rows.";

	//this.flatRows = this.flattenRows(this.rows)
}


Query.prototype.flattenRows = function (rows) {
	var collection = [],
		self = this;
	$.each(rows,function(key, row){
		collection[key] = self.flattenObject(row);
	});
	return collection;
};

Query.prototype.flattenObject = function (obj, current, res) {
	var res = res? res: {};
  for(var key in obj) {
    var value = obj[key];
    var newKey = (current ? current + "." + key : key);  // joined key with dot
    if(value && typeof value === "object") {
      flattenObject(value, newKey, res);  // it's a nested object, so do it again
    } else {
      res[newKey] = value;  // it's not an object, so set the property
    }
  }
  return res;
};

Query.prototype.where = function(key,value){

	this.rows = $.grep(this.rows,function(item){
		return (item[key] == value);
	});	
	return this;
};

Query.prototype.whereDeep = function(key, value){
	this.rows = $.grep(this.flatRows,function(item, itemIndex){
		return (item[key] == value);
	});
	return this;
}

//performs search on a sub queriable object collection
Query.prototype.whereEachOf = function(key,callBack){
	this.rows = $.grep(this.rows,function(item){
		var q = callBack(Store.query(item[key]));
		return Boolean(q.count());
	});	
	return this;
};

Query.prototype.get = function(){
	return this.rows;
};

Query.prototype.first = function(){
	if(!this.rows.length)
		return null;
	var first  = this.rows.shift();
	this.rows.unshift(first);
	return first;	
};

Query.prototype.count = function(){
	return this.rows.length;	
};


Query.prototype.find = function(val){
	return this.where('id',val).first();
};

Query.prototype.column = function(column){
	var collection = [];
	$.each(this.rows,function(key, row){
		if(row[column])
			collection.push(row[column])
	});
	return collection;
};

Query.prototype.unique = function(){
	var collection = [];
	this.rows = this.rows.reduce(function(collection, item){
		if(!Store.query(collection).find(item.id))
			collection.push(item);
		return collection
	},[]);
	return this;
};

Query.prototype.sum = function(column){
	return this.rows.reduce(function(total, item){
		var sum = parseFloat(item[column])+total;
		return isNaN(sum)? total : sum;
	},0);
};


