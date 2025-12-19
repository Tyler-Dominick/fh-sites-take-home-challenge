<?php

namespace PokerHand;

class PokerHand
{

    private $hand;
    private $rank;
    private $rankValues = [
        '2'  => 2,
        '3'  => 3,
        '4'  => 4,
        '5'  => 5,
        '6'  => 6,
        '7'  => 7,
        '8'  => 8,
        '9'  => 9,
        '10' => 10,
        'J'  => 11,
        'Q'  => 12,
        'K'  => 13,
        'A'  => 14
    ];

    public function __construct($hand)
    {
        $this->hand = $hand;
        $this->rank = $this->getRank();
    }

    public function getRank()
    {
        // TODO: Implement poker hand ranking
        $list_of_cards = explode(' ', $this->hand);
        $new_list_of_cards = [];
        $list_of_ranks = [];
        $list_of_suits = [];
        $rank_counts = [];
        $suit_counts = [];
        
        //cheater check
        if(count(array_unique($list_of_cards)) !== 5){
            echo "Invalid hand - Duplicate cards detected\n";
            echo "INITIATING CHEATER PROTOCOL\n";
            echo "*SENDING ALARM TO THE POLICE\n";
            echo "*CALLING THE FBI\n";
            echo "*CALLING THE CIA\n";
            echo "*CALLING THE NSA\n";
            echo "*SENDING IN SHARKS WITH FRIGGIN LASER BEAMS\n";
            return;
        }

        // for every card, get the rank and suit. Add to new list of cards and list of ranks.
        foreach($list_of_cards as $card){
            $suit = substr($card, -1);
            $rank = substr($card, 0, -1);
            $rankValue = $this->rankValues[$rank];
            array_push($new_list_of_cards, [$rankValue, $suit]);
            array_push($list_of_ranks, $rankValue);
            array_push($list_of_suits, $suit);
        }
        
        // sort and count the list of ranks
        sort($list_of_ranks);
        foreach($list_of_ranks as $rank){
            $rank_counts[$rank] = ($rank_counts[$rank] ?? 0) + 1;
        }
        //count the list of suits
        foreach($list_of_suits as $suit){
            $suit_counts[$suit] = ($suit_counts[$suit] ?? 0) + 1;
        }

        //return the rank of the hand
        if($this->isRoyal($list_of_ranks) && $this->isflush($suit_counts)){
            return 'Royal Flush';
        }
        elseif($this->isflush($suit_counts) && $this->isstraight($list_of_ranks)){
            return 'Straight Flush';
        }
        elseif($this->isflush($suit_counts)){
            return 'Flush';
        }
        elseif($this->isstraight($list_of_ranks)){
            return 'Straight';
        }
        elseif($this->isFourOfAKind($rank_counts)){
            return 'Four of a Kind';
        }
        elseif($this->isFullHouse($rank_counts)){
            return 'Full House';
        }
        elseif($this->isThreeOfAKind($rank_counts)){
            return 'Three of a Kind';
        }
        elseif($this->isTwoPair($rank_counts)){
            return 'Two Pair';
        }
        elseif($this->isOnePair($rank_counts)){
            return 'One Pair';
        }
        else{
            return 'High Card';
        }
    }
    //helper functions
    public function isRoyal($list_of_ranks){
        return $list_of_ranks === [10, 11, 12, 13, 14];
    }
    public function isflush($suit_counts)
    {
        return count($suit_counts) === 1;
    }
    public function isstraight($list_of_ranks){
        return $list_of_ranks[4] - $list_of_ranks[0] === 4 || $list_of_ranks === [2, 3, 4, 5, 14];
    }
    public function isFourOfAKind($rank_counts){
        return in_array(4, $rank_counts) && count($rank_counts) === 2;
    }
    public function isFullHouse($rank_counts){
        return count($rank_counts) === 2 
            && in_array(2, $rank_counts) 
            && in_array(3, $rank_counts);
    }
    //will return true on Full houses but we always check for a full house first in our ranking logic. Could make this more specific by excluding full houses.
    public function isThreeOfAKind($rank_counts){
        return in_array(3, $rank_counts);
    }
    public function isTwoPair($rank_counts){
        $pairs = 0;
        foreach($rank_counts as $count) {
            if ($count === 2) {
                $pairs++;
            }
        }
        return $pairs === 2 && count($rank_counts) === 3;
    }
    //will return true on higher hands but we always check for a one pair after higher hands in our ranking logic. Could make this more specific by excluding higher hands.
    public function isOnePair($rank_counts){
        return in_array(2, $rank_counts);
    }
    

}