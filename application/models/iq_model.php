<?php
    /**
     * Created by John Huseinovic
     * Date: 15/11/12
     * Time: 5:07 PM
     */
class Iq_model extends MY_Model
{
    var $Q_1 = "Which one of the five is least like the other four?";
    var $Q_1_Answers = array(1=>"Shark",2=>"Deer",3=>"Cow",4=>"Dog",5=>"Lion");
    var $Q_1_Correct = "Shark";

    var $Q_2 = "Which one of the five makes the best comparison? Son is to mother as nephew is to:";
    var $Q_2_Answers = array(1=>"Aunt",2=>"Mother",3=>"Daughter",4=>"Uncle",5=>"Nephew");
    var $Q_2_Correct = "Aunt";

    var $Q_3 = "Which one of the letters does not belong in the following series: D - F - H - J - K - N - P - R";
    var $Q_3_Answers = array(1=>"D",2=>"H",3=>"K",4=>"P",5=>"R");
    var $Q_3_Correct = "K";

    var $Q_4 = "Two of the following numbers add up to seventeen. 6 - 13 - 2 - 12 - 7 - 14";
    var $Q_4_Answers = array(1=>"True",2=>"False",3=>"",4=>"",5=>"");
    var $Q_4_Correct = "False";

    var $Q_5 = "How many months in a year have 28 days?";
    var $Q_5_Answers = array(1=>"1",2=>"2",3=>"6",4=>"12",5=>"");
    var $Q_5_Correct = "12";

    var $Q_6 = "Mike, six years old, is twice as old as his brother. How old will Mike be when he is one and a half times as old as his brother?";
    var $Q_6_Answers = array(1=>"3",2=>"5",3=>"7",4=>"9",5=>"");
    var $Q_6_Correct = "9";

    var $Q_7 = "What is the next number in the following series? 16 - 11 - 13 - 8 - 10 - 5 - 7 -";
    var $Q_7_Answers = array(1=>"4",2=>"6",3=>"-1",4=>"2",5=>"");
    var $Q_7_Correct = "2";

    var $Q_8 = "At a store, they cut the price 40% for a particular item. By what percent must the item be increased if you wanted to sell it at the original price?";
    var $Q_8_Answers = array(1=>"33%",2=>"60%",3=>"66.7%",4=>"88.2%",5=>"");
    var $Q_8_Correct = "66.7%";

    var $Q_9 = "If the day before the day before yesterday is three days after Saturday. What day is it today?";
    var $Q_9_Answers = array(1=>"Monday",2=>"Tuesday",3=>"Wednesday",4=>"Thursday",5=>"Friday");
    var $Q_9_Correct = "Friday";

}