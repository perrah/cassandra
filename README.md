# Cassandra: Data Mining
Cassandra: Data Mining is a web based tool that provides data mining techniques to users. These techniques are currently limited to  supervised classification model creation and predicting but later version could include other techniques. 

Users can download and make use of Cassandra: Data Mining on personal and commercial machines or servers under the open liscence. 

## Data Mining
Data Mining is a series of techniques that can be used to provide real insightful meaning from data. Cassandra: Data Mining currently only provides a supervised classification technique and does so in the form of a decision tree. 

Supervised learning, opposed to unsupervised, uses historically known data to create a model which can then be used to apply new data to create a prediction. Cassandra: Data Mining provides the tools neccessary for a user to do such modelling and predictive analysis.

## Motivation
The motivation behind Cassandra: Data Mining began as a Final Year Project Dissertation for the Univeristy of West of England, Bristol. The idea of which came from past experience in analysis within a service management role and how technology could be used to predict incidents of provided services and create a proactive rather than reactive environment for service management.

## Installation
Installation requires some installation of other tools available for free:

1. <strong>[WAMP Server](http://www.wampserver.com/en/)</strong>: prodives PHP, MySQL and an Apache Server.
2. <strong>[Anaconda](https://store.continuum.io/cshop/anaconda/)</strong>: Provides scientific and mathmatical Python Libraries (Numpy, Scikit-Learn, Pandas, etc) and Python itself.

Cassandra installation and setup:

3. Download cassandra source packages to your <strong>localhost directory</strong>
4. Ensure `cassandra/res/config/setup-config.php` states both the `setup` and `admin` variables as <strong>`no`</strong>
5. Open Cassandra: Data Mining in a browser (via localhost, ensuring WAMP services are online)
6. Follow Installation Wizard

The following actions setup a database and the required tables in MySQL. After which the user will be asked to create an admin user. This completes the installation process of Cassandra: Data Mining.

## Tests

Anaconda Tests: To test that anaconda has succesfully installed

1. Open cmd and type `python` to execute python. The print out should read an Anaconda about `ctrl + z` to exit
2. Create a `simple_tree.py` file containing the following:

```from sklearn import tree
X = [[0, 0], [1, 1]]
Y = [0, 1]
clf = tree.DecisionTreeClassifier()
clf = clf.fit(X, Y)
print(clf.predict([[2., 2.]]))
```
3. In cmd change to the file directory and type `python simple_tree.py`
4. `[1]` should be returned 

This means anaconda and the sklearn libraries have been succesfully installed.

## Contributers
Cassandra: Data Mining has much room for improvement and much more functionality that can be added to improve the tool and provide more Data Mining techqniues: Supervised and Unsupervised.

Under the open source lisence anyone is welcome to download and make further contributions to the project. If any information is required in how to do so feel free to get into contact.

## Lisence 
Open Source
