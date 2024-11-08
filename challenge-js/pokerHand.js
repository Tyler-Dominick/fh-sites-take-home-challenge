class PokerHand {
  
  constructor(hand) {
    this.hand = hand.split(" ")
  }

  getRank() {
    // Implement poker hand ranking
      const ranks = '23456789TJQKA';
      const suits = this.hand.map(card => card[card.length - 1]);
      let values = this.hand
        .map(card => {
            // Match ranks: either "10" for 10s or a single character for others
            const rank = card.slice(0, card.length - 1);  // Extract rank without the suit
            if (rank === 'A') return 14;  // Ace as 14 by default
            if (rank === 'K') return 13;
            if (rank === 'Q') return 12;
            if (rank === 'J') return 11;
            if (rank === 'T') return 10;  // "T" represents 10
            return parseInt(rank);  // For numeric ranks "2" to "9"
        })
        .sort((a, b) => a - b);  // Ensure numeric sorting in ascending order
  
      //console.log("Values (sorted):", values);  // Debug: Check sorted values
  
      const uniqueValues = [...new Set(values)];
      const uniqueSuits = [...new Set(suits)];
      const isFlush = uniqueSuits.length === 1;
  
      // Check for a straight: either a regular straight or a special case (A, 2, 3, 4, 5)
      const isRegularStraight = uniqueValues.length === 5 && uniqueValues[4] - uniqueValues[0] === 4;
      const isLowAceStraight = JSON.stringify(uniqueValues) === JSON.stringify([2, 3, 4, 5, 14]);
      const isStraight = isRegularStraight || isLowAceStraight;
  
      // console.log("Is Regular Straight:", isRegularStraight);  // Debug: Check if it's a regular straight
      // console.log("Is Low Ace Straight:", isLowAceStraight);  // Debug: Check if it's a low Ace straight
      // console.log("Is Straight:", isStraight);  // Debug: Final straight check
  
      // Check if hand is a Royal Flush
      const isRoyal = isFlush && isRegularStraight && Math.max(...values) === 14;
  
      // Count occurrences of each rank to identify pairs, three of a kind, etc.
      const rankCounts = {};
      values.forEach(value => rankCounts[value] = (rankCounts[value] || 0) + 1);
      const counts = Object.values(rankCounts).sort((a, b) => b - a);
  
      // console.log("Rank Counts:", rankCounts);  // Debug: Check rank occurrences
      // console.log("Counts:", counts);  // Debug: Check counts for pairs, three of a kind, etc.
  
      // Determine the hand type based on conditions
      if (isRoyal) return 'Royal Flush';
      if (isFlush && isStraight) return 'Straight Flush';
      if (counts[0] === 4) return 'Four of a Kind';
      if (counts[0] === 3 && counts[1] === 2) return 'Full House';
      if (isFlush) return 'Flush';
      if (isStraight) return 'Straight';
      if (counts[0] === 3) return 'Three of a Kind';
      if (counts[0] === 2 && counts[1] === 2) return 'Two Pair';
      if (counts[0] === 2) return 'One Pair';
      return 'High Card';
   }

  } 




module.exports = PokerHand;
