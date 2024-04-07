<?php 
namespace App\Enums;

enum CategoryProductTools : string
{
    case HAMMER = 'hammer';
    case SCREWDRIVER = 'screwdriver';
    case WRENCH = 'wrench';
    case PLIERS = 'pliers';
    case SAW = 'saw';
    case DRILL = 'drill';

    case AXE = 'axe';
    case CHISEL = 'chisel';
    case LEVEL = 'level';
    case TAPE_MEASURE = 'tape_measure';
    case UTILITY_KNIFE = 'utility_knife';
    case LADDER = 'ladder';

    case TOOLBOX = 'toolbox';
    case TOOL_CHEST = 'tool_chest';
    case TOOL_BAG = 'tool_bag';
    case TOOL_BELT = 'tool_belt';
    case TOOL_RACK = 'tool_rack';
    case TOOL_HOLDER = 'tool_holder';

    case WORKBENCH = 'workbench';
    case WORKTABLE = 'worktable';

    case SAFETY_GLASSES = 'safety_glasses';
    case GLOVES = 'gloves';
    case MASK = 'mask';
    case EAR_PLUGS = 'ear_plugs';
    case HARD_HAT = 'hard_hat';
    case VEST = 'vest';
    case KNEE_PADS = 'knee_pads';
}