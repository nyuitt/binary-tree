<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CalculatePointsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    private function calculateDescendantPoints($user)
    {
      
        $totalPoints = $user->points;

        if ($user->leftChild) {
            $leftPoints = $this->calculateDescendantPoints($user->leftChild);
            if ($leftPoints !== $user->leftChild->points) {
                $user->leftChild->points = $leftPoints;
                $user->leftChild->save();
            }
            $totalPoints += $leftPoints;
        }

        if ($user->rightChild) {
            $rightPoints = $this->calculateDescendantPoints($user->rightChild);
            if ($rightPoints !== $user->rightChild->points) {
                $user->rightChild->points = $rightPoints;
                $user->rightChild->save();
            }
            $totalPoints += $rightPoints;
        }

        return $totalPoints;
    }
}
