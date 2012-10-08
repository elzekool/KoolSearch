KoolSearch
==========

A Lucene inspired Search platform, very simple at the moment. Can be used if a simple LIKE query won't suffice.
It's not meant to replace SOLR or Lucene in any way, they are far superior. Use KoolSearch if you want to know
a little bit about search platforms or need a simple PHP/MySQL only solution.

KoolSearch is meant to be used together with the KoolDevelop framework but it can be used without. Filenames are
following the PSR-0 standard. You have to write your own Storage classes.

Some example queries the KoolSearch platform understands:
* Apple -Computer
* OS +"MS Dos"
* +Linus +Tovalds
* +title:Ubuntu title:Linux "OS"

## Main Parts ##
This are the main parts that make up the KoolSearch platform. 
* Indexer and Searcher
* Storage 
* Filters (CharFilter, Tokenizer, Transformer)
* Query Tokenizer, Parser and Elements
* Entities

### Indexer and Searcher ###
This are the classes you will be talking to the most. The Indexer is used to update the index, the Searcher is used to
query the index.

### Storage ###
The KoolSearch platform uses a SQL database to store the index. The Storage interfaces are used to interface the database.
Standard classes are provided if using the KoolDevelop framework. Create your own if you are not using this framework.

### Filters (CharFilter, Tokenizer, Transformer) ###
Are used for indexing and searching transforming strings into terms. **CharFilters** work on the raw input string and perform things like lowercasing, replacing special characters, etc. **Tokenizers** transforms the filtered input string to individual tokens or terms. This terms are what are actualy stored and retrieved from the database. **Transformers** can be used to manipulate terms. The work on the tokenized terms instead of the input string. This makes them different from the **CharFilters**. Transformers do things like removing duplicate terms, removing stopwords and making NGrams.

### Query Tokenizer, Parser and Elements ###
